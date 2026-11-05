<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * Sign-in refused: the account is « Suspendu » (FR-02).
 */
class AccountSuspendedException extends DomainException
{
    protected ?string $field = 'email';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.suspended');
    }
}
