<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * Wrong e-mail or password: one generic message, whatever was wrong (FR-02).
 */
class InvalidCredentialsException extends DomainException
{
    protected ?string $field = 'email';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.invalid_credentials');
    }
}
