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

        $user = User::query()->where('email', mb_strtolower($email))->first();

        // Hash even for an unknown address, so the response time does not reveal accounts.
        $passwordMatches = Hash::check($password, $user->password ?? Hash::make('unknown-account'));

        if ($user === null || ! $passwordMatches) {
            $this->recordFailure($ip, $user);

            throw new InvalidCredentialsException;
        }

        $this->clearFailures($ip);
        $this->start($user);

        return $user;
    }

    /**
     * Refuse the attempt while the device / IP is in its waiting period.
     */
    public function ensureNotThrottled(string $ip): void
    {
        $blockedUntil = Cache::get($this->blockedUntilKey($ip));

        if (is_int($blockedUntil) && $blockedUntil > now()->getTimestamp()) {
            throw new SignInThrottledException($blockedUntil - now()->getTimestamp());
        }
    }

    /**
     * Count a failed password attempt. From the 3rd consecutive failure the device / IP waits
     * 30 s, doubling at each failure up to 15 minutes; the targeted account's holder is alerted.
     * The account itself is never locked.
     */
    public function recordFailure(string $ip, ?User $targetedUser): void
    {
        $failures = (int) Cache::get($this->failuresKey($ip), 0) + 1;
        Cache::put($this->failuresKey($ip), $failures, now()->addDay());

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
     * A successful password step ends the slow-down of the device / IP.
     */
    public function clearFailures(string $ip): void
    {
        Cache::forget($this->failuresKey($ip));
        Cache::forget($this->blockedUntilKey($ip));
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
