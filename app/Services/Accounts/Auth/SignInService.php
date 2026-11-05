<?php

namespace App\Services\Accounts\Auth;

use App\Enums\AccountStatus;
use App\Exceptions\Accounts\Auth\AccountRefusedException;
use App\Exceptions\Accounts\Auth\AccountSuspendedException;
use App\Exceptions\Accounts\Auth\InvalidCredentialsException;
use App\Exceptions\Accounts\Auth\SignInThrottledException;
use App\Models\Accounts\SignInCode;
use App\Models\User;
use App\Notifications\Accounts\SignInThrottledNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * The sign-in flow around the password step (FR-02): the slow-down after failed attempts
 * and the account-status checks made before a code is sent. Not tied to one model.
 */
class SignInService
{
    /**
     * Failures from one device / IP before attempts are slowed down.
     */
    public const int FreeFailures = 3;

    /**
     * The first wait, in seconds; it doubles at each further failure.
     */
    public const int FirstWaitSeconds = 30;

    /**
     * The longest wait, in seconds (15 minutes).
     */
    public const int MaxWaitSeconds = 900;

    /**
     * Session key of the account waiting for its e-mail code.
     */
    public const string PendingUserKey = 'sign_in.user_id';

    /**
     * Session key of the « Se souvenir de moi » choice made at the password step.
     */
    public const string PendingRememberKey = 'sign_in.remember';

    public function __construct(private SignInCodeService $signInCodeService) {}

    /**
     * The password step: unless the device / IP is waiting, check the credentials, then the
     * account status, and send the e-mail code. Nobody is signed in until the code is entered.
     */
    public function attempt(string $email, string $password, string $ip): User
    {
        $this->ensureNotThrottled($ip);

        $email = mb_strtolower(trim($email));
        $user = User::query()->where('email', $email)->first();

        // One hash check whether or not the address exists, so the response time does not reveal accounts.
        $passwordMatches = Hash::check($password, $user->password ?? $this->unknownAccountHash());

        if ($user === null || ! $passwordMatches) {
            $this->recordFailure($ip, $email, $user);

            throw new InvalidCredentialsException;
        }

        $this->clearFailures($ip, $email);
        $this->start($user);

        return $user;
    }

    /**
     * Refuse the attempt while the device / IP is in its waiting period.
     */
    public function ensureNotThrottled(string $ip): void
    {
        // Stores such as Redis hand numbers back as strings.
        $blockedUntil = Cache::get($this->blockedUntilKey($ip));

        if (is_numeric($blockedUntil) && (int) $blockedUntil > now()->getTimestamp()) {
            throw new SignInThrottledException((int) $blockedUntil - now()->getTimestamp());
        }
    }

    /**
     * Count a failed password attempt. From the 3rd consecutive failure the device / IP waits
     * 30 s, doubling at each failure up to 15 minutes; the targeted account's holder is alerted.
     * The account itself is never locked.
     *
     * The failures are also counted per address, so a later success only takes back its own.
     */
    public function recordFailure(string $ip, string $email, ?User $targetedUser): void
    {
        $failures = $this->incrementFor($this->failuresKey($ip));
        $this->incrementFor($this->addressFailuresKey($ip, $email));

        if ($failures < self::FreeFailures) {
            return;
        }

        $wait = (int) min(self::FirstWaitSeconds * 2 ** ($failures - self::FreeFailures), self::MaxWaitSeconds);
        Cache::put($this->blockedUntilKey($ip), now()->getTimestamp() + $wait, now()->addSeconds($wait));

        if ($targetedUser !== null && Cache::add("sign-in-alert:{$targetedUser->id}", true, now()->addMinutes(15))) {
            $targetedUser->notify(new SignInThrottledNotification);
        }
    }

    /**
     * A successful password step takes back the failures made on that address from the device / IP,
     * and ends its slow-down when none remain. Failures on other addresses keep counting, so signing
     * in to one's own account cannot reset guesses made on someone else's.
     */
    public function clearFailures(string $ip, string $email): void
    {
        $addressFailures = (int) Cache::pull($this->addressFailuresKey($ip, $email), 0);

        if ($addressFailures === 0) {
            return;
        }

        $remaining = (int) Cache::decrement($this->failuresKey($ip), $addressFailures);

        if ($remaining <= 0) {
            Cache::forget($this->failuresKey($ip));
            Cache::forget($this->blockedUntilKey($ip));
        }
    }

    /**
     * After a correct password: refuse suspended and refused accounts, then send the e-mail code.
     * Other statuses sign in with restricted access (FR-36, FR-46).
     */
    public function start(User $user): SignInCode
    {
        match ($user->status) {
            AccountStatus::Suspended => throw new AccountSuspendedException,
            AccountStatus::Refused => throw new AccountRefusedException((string) $user->status_reason),
            default => null,
        };

        return $this->signInCodeService->issue($user);
    }

    /**
     * « Se souvenir de moi » keeps the session 30 days, never for administrators.
     */
    public function mayRemember(User $user, bool $requested): bool
    {
        return $requested && ! $user->role->isAdministrator();
    }

    /**
     * Add one to a failure counter kept for a day, atomically, and return the new count.
     */
    private function incrementFor(string $key): int
    {
        Cache::add($key, 0, now()->addDay());

        return (int) Cache::increment($key);
    }

    /**
     * A hash to check passwords against for unknown addresses: made once, with the current
     * hashing cost, so the check takes as long as for a real account.
     */
    private function unknownAccountHash(): string
    {
        return Cache::rememberForever('sign-in-unknown-account-hash', fn (): string => Hash::make(Str::random(40)));
    }

    /**
     * The cache key counting a device / IP's failures on one address.
     */
    private function addressFailuresKey(string $ip, string $email): string
    {
        return 'sign-in-failures:'.sha1($ip).':'.sha1($email);
    }

    /**
     * The cache key counting a device / IP's consecutive failures.
     */
    private function failuresKey(string $ip): string
    {
        return 'sign-in-failures:'.sha1($ip);
    }

    /**
     * The cache key holding when a device / IP may try again.
     */
    private function blockedUntilKey(string $ip): string
    {
        return 'sign-in-blocked-until:'.sha1($ip);
    }
}
