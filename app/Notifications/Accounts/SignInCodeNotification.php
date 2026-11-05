<?php

namespace App\Notifications\Accounts;

use App\Models\Accounts\SignInCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * The 6-digit sign-in code (FR-02). Queued and retried while the mail service is down;
 * encrypted on the queue because it carries the plain code. Its 5-minute validity
 * starts when it is actually sent (SignInCodeService::markDelivered on NotificationSent).
 */
class SignInCodeNotification extends Notification implements ShouldBeEncrypted, ShouldQueue
{
    use Queueable;

    /**
     * The number of times the notification may be attempted.
     */
    public int $tries = 10;

    public function __construct(public SignInCode $signInCode, public string $code) {}

    /**
     * The seconds to wait between attempts.
     *
     * @return list<int>
     */
    public function backoff(): array
    {
        return [10, 30, 60, 120];
    }

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
            ->subject(__('accounts.sign_in.mail.code_subject'))
            ->line(__('accounts.sign_in.mail.code_line', ['code' => $this->code]))
            ->line(__('accounts.sign_in.mail.code_validity'))
            ->line(__('accounts.sign_in.mail.code_ignore'));
    }
}
