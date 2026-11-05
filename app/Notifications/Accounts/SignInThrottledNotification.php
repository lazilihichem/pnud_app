<?php

namespace App\Notifications\Accounts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Alert to the account holder: failed sign-ins on their account are being slowed down (FR-02).
 */
class SignInThrottledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('accounts.sign_in.mail.throttled_subject'))
            ->line(__('accounts.sign_in.mail.throttled_line'))
            ->line(__('accounts.sign_in.mail.throttled_safe'));
    }
}
