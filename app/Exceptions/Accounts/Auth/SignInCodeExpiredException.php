<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * The sign-in code's 5 minutes are over (FR-02).
 */
class SignInCodeExpiredException extends DomainException
{
    protected ?string $field = 'code';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.code_expired');
    }
}
