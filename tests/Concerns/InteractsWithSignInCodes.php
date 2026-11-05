<?php

namespace Tests\Concerns;

use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;

/**
 * Reads the e-mailed sign-in code in tests (requires Notification::fake()).
 */
trait InteractsWithSignInCodes
{
    /**
     * The last code e-mail sent to the user.
     */
    protected function lastSignInCodeNotification(User $user): SignInCodeNotification
    {
        $notification = Notification::sent($user, SignInCodeNotification::class)->last();
        $this->assertInstanceOf(SignInCodeNotification::class, $notification, 'No sign-in code was sent.');

        return $notification;
    }

    /**
     * Deliver the last code e-mail (its 5 minutes start now) and return the plain code.
     */
    protected function deliverSignInCode(User $user): string
    {
        $notification = $this->lastSignInCodeNotification($user);

        event(new NotificationSent($user, $notification, 'mail'));

        return $notification->code;
    }

    /**
     * Pass the password step and enter the delivered code.
     */
    protected function signInWithCode(User $user, string $password = 'password', bool $remember = false): TestResponse
    {
        $this->post(route('login.store'), ['email' => $user->email, 'password' => $password, 'remember' => $remember ? '1' : null]);

        return $this->post(route('login.code.verify'), ['code' => $this->deliverSignInCode($user)]);
    }
}
