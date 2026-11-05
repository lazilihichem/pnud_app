<?php

namespace App\Exceptions\Accounts;

use App\Exceptions\DomainException;

/**
 * « Renvoyer le code »: 60 s after a send, at most 3 sends per 15 minutes (FR-02).
 */
class SignInCodeResendTooEarlyException extends DomainException
{
    protected ?string $field = 'code';

    public function __construct(public readonly int $seconds)
    {
        parent::__construct('accounts.sign_in.resend_too_early');

        $this->status = 429;
        $this->replace = ['seconds' => $seconds];
    }
}
