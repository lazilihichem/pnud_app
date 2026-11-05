<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * 3 wrong entries invalidated the sign-in code (FR-02).
 */
class SignInCodeExhaustedException extends DomainException
{
    protected ?string $field = 'code';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.code_exhausted');
    }
}
