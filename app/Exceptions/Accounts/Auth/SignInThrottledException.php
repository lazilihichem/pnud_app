<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * Too many failed sign-ins from this device or IP: wait before retrying (FR-02).
 */
class SignInThrottledException extends DomainException
{
    protected ?string $field = 'email';

    public function __construct(public readonly int $seconds)
    {
        parent::__construct('accounts.sign_in.throttled');

        $this->status = 429;
        $this->replace = ['seconds' => $seconds];
    }
}
