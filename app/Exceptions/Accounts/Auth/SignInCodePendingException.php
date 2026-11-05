<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * The code e-mail has not been delivered yet (FR-02).
 */
class SignInCodePendingException extends DomainException
{
    protected ?string $field = 'code';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.code_pending');
    }
}
