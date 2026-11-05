<?php

namespace App\Services\Accounts;

use App\Exceptions\Accounts\SignInCodeExhaustedException;
use App\Exceptions\Accounts\SignInCodeExpiredException;
use App\Exceptions\Accounts\SignInCodeIncorrectException;
use App\Exceptions\Accounts\SignInCodePendingException;
use App\Exceptions\Accounts\SignInCodeResendTooEarlyException;
use App\Models\Accounts\SignInCode;
use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
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
     */
    public function issue(User $user): SignInCode
    {
        $latest = $this->latestFor($user);

        if ($latest !== null && $this->sendsInWindow($user) >= self::MaxSendsPerWindow) {
            return $latest;
        }

        $code = str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);

        // A new code supersedes the previous ones: only the latest can be entered.
        $user->signInCodes()->whereNull('used_at')->update(['used_at' => now()]);

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
            $oldestInWindow = $user->signInCodes()
                ->where('created_at', '>', now()->subMinutes(self::WindowMinutes))
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
     */
    public function verify(User $user, string $code): void
    {
        $signInCode = $this->latestFor($user);

        if ($signInCode === null || $signInCode->used_at !== null) {
            throw new SignInCodeExpiredException;
        }

        if ($signInCode->isExhausted()) {
            throw new SignInCodeExhaustedException;
        }

        if ($signInCode->isPendingDelivery()) {
            throw new SignInCodePendingException;
        }

        if ($signInCode->isExpired()) {
            throw new SignInCodeExpiredException;
        }

        if (! Hash::check($code, $signInCode->code_hash)) {
            $signInCode->increment('failed_attempts');

            throw $signInCode->isExhausted()
                ? new SignInCodeExhaustedException
                : new SignInCodeIncorrectException;
        }

        $signInCode->forceFill(['used_at' => now()])->save();

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
     * How many codes were sent within the last 15 minutes.
     */
    private function sendsInWindow(User $user): int
    {
        return $user->signInCodes()
            ->where('created_at', '>', now()->subMinutes(self::WindowMinutes))
            ->count();
    }
}
