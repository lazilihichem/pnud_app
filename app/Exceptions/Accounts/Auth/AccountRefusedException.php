<?php

namespace App\Exceptions\Accounts\Auth;

use App\Exceptions\DomainException;

/**
 * Sign-in refused: the registration was « Refusé », shown with its reason (FR-02).
 */
class AccountRefusedException extends DomainException
{
    protected ?string $field = 'email';

    public function __construct(string $reason)
    {
        parent::__construct('accounts.sign_in.refused');

        $this->replace = ['reason' => $reason];
    }
}
