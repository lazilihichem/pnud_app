<?php

namespace App\Exceptions\Accounts;

use App\Exceptions\DomainException;

/**
 * The entered sign-in code is wrong (FR-02).
 */
class SignInCodeIncorrectException extends DomainException
{
    protected ?string $field = 'code';

    public function __construct()
    {
        parent::__construct('accounts.sign_in.code_incorrect');
    }
}
