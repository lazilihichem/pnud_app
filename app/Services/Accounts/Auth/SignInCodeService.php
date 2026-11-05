<?php

namespace App\Services\Accounts\Auth;

use App\Exceptions\Accounts\Auth\SignInCodeExhaustedException;
use App\Exceptions\Accounts\Auth\SignInCodeExpiredException;
use App\Exceptions\Accounts\Auth\SignInCodeIncorrectException;
use App\Exceptions\Accounts\Auth\SignInCodePendingException;
use App\Exceptions\Accounts\Auth\SignInCodeResendTooEarlyException;
use App\Exceptions\DomainException;
use App\Models\Accounts\SignInCode;
use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * The 6-digit e-mail code required at every sign-in (FR-02). Every expiry and limit is enforced here.
 */
class SignInCodeService
{
    /**
     * Seconds after a send before « Renvoyer le code » is available.
     */
    public const int ResendCooldownSeconds = 60;

    /**
     * Codes that can be sent within the window.
     */
    public const int MaxSendsPerWindow = 3;

    /**
     * The sending window, in minutes.
     */
    public const int WindowMinutes = 15;

    /**
     * Send a new code, unless 3 were already sent in the last 15 minutes: the latest one then stays current.
     * Codes that completed a sign-in do not count, so signing in again always gets a new code.
     */
    public function issue(User $user): SignInCode
    {
        $latest = $this->latestFor($user);

        if ($latest !== null && $this->sendsInWindow($user) >= self::MaxSendsPerWindow) {
            return $latest;
        }

        $code = str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);

        // A new code supersedes the previous ones: verify() only accepts the latest.
        $signInCode = $user->signInCodes()->create(['code_hash' => Hash::make($code)]);

        $user->notify(new SignInCodeNotification($signInCode, $code));

        return $signInCode;
    }

    /**
     * « Renvoyer le code »: 60 s after the last send, at most 3 sends per 15 minutes.
     */
    public function resend(User $user): SignInCode
    {
        $wait = $this->resendAvailableIn($user);

        if ($wait > 0) {
            throw new SignInCodeResendTooEarlyException($wait);
        }

        return $this->issue($user);
    }

    /**
     * Seconds before a new code can be sent, 0 when it can be sent now.
     */
    public function resendAvailableIn(User $user): int
    {
        $latest = $this->latestFor($user);

        if ($latest === null) {
            return 0;
        }

        $cooldownEnd = $latest->created_at->copy()->addSeconds(self::ResendCooldownSeconds);
        $windowEnd = now();

        if ($this->sendsInWindow($user) >= self::MaxSendsPerWindow) {
            $oldestInWindow = $this->sentInWindow($user)
                ->oldest('id')
                ->firstOrFail();

            $windowEnd = $oldestInWindow->created_at->copy()->addMinutes(self::WindowMinutes);
        }

        $availableAt = $cooldownEnd->max($windowEnd);

        return max(0, (int) ceil(now()->diffInSeconds($availableAt, false)));
    }

    /**
     * Start the 5-minute validity when the code e-mail is actually delivered.
     */
    public function markDelivered(SignInCode $signInCode): void
    {
        $signInCode->forceFill([
            'delivered_at' => now(),
            'expires_at' => now()->addMinutes(SignInCode::LifetimeMinutes),
        ])->save();
    }

    /**
     * Check the code entered by the user; a valid code is used up and verifies the e-mail address.
     *
     * The code row is locked while it is checked, so parallel guesses are counted one after the
     * other and cannot exceed the 3 attempts.
     */
    public function verify(User $user, string $code): void
    {
        $failure = DB::transaction(function () use ($user, $code): ?DomainException {
            $signInCode = $user->signInCodes()->latest('id')->lockForUpdate()->first();

            if ($signInCode === null || $signInCode->used_at !== null) {
                return new SignInCodeExpiredException;
            }

            if ($signInCode->isExhausted()) {
                return new SignInCodeExhaustedException;
            }

            if ($signInCode->isPendingDelivery()) {
                return new SignInCodePendingException;
            }

            if ($signInCode->isExpired()) {
                return new SignInCodeExpiredException;
            }

            if (! Hash::check($code, $signInCode->code_hash)) {
                $signInCode->increment('failed_attempts');

                return $signInCode->isExhausted()
                    ? new SignInCodeExhaustedException
                    : new SignInCodeIncorrectException;
            }

            $signInCode->forceFill(['used_at' => now()])->save();

            return null;
        });

        // Thrown after the commit, so the counted attempt is kept.
        if ($failure !== null) {
            throw $failure;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }

    /**
     * The most recent code sent to the user.
     */
    public function latestFor(User $user): ?SignInCode
    {
        return $user->signInCodes()->latest('id')->first();
    }

    /**
     * How many codes count towards the limit of the last 15 minutes.
     */
    private function sendsInWindow(User $user): int
    {
        return $this->sentInWindow($user)->count();
    }

    /**
     * The codes sent within the last 15 minutes that did not complete a sign-in (used_at is
     * only set by a successful entry).
     *
     * @return HasMany<SignInCode, User>
     */
    private function sentInWindow(User $user): HasMany
    {
        return $user->signInCodes()
            ->where('created_at', '>', now()->subMinutes(self::WindowMinutes))
            ->whereNull('used_at');
    }
}
