<?php

namespace App\Notifications\Accounts;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * The e-mail verification link, queued and retried while the mail service is down (FR-01).
 *
 * The signed link is built when the queued job runs, so its 24-hour validity
 * (auth.verification.expire) starts at sending rather than at registration.
 */
class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the notification may be attempted.
     */
    public int $tries = 10;

    /**
     * The seconds to wait between attempts.
     *
     * @return list<int>
     */
    public function backoff(): array
    {
        return [60, 300, 900, 1800];
    }
}
