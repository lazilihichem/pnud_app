<?php

namespace App\Http\Requests\Accounts\Auth;

use App\Models\User;
use App\Services\Accounts\Auth\SignInService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use LogicException;

/**
 * Base of the code-step requests: a signed-out visitor who passed the password step (FR-02).
 */
abstract class PendingSignInRequest extends FormRequest
{
    private ?User $pendingUser = null;

    /**
     * Only a visitor waiting for their e-mail code may use the code step.
     */
    public function authorize(): bool
    {
        return $this->user() === null && $this->pendingUser() !== null;
    }

    /**
     * Without a pending sign-in, start again from the sign-in page.
     */
    protected function failedAuthorization(): never
    {
        throw new HttpResponseException(to_route('login'));
    }

    /**
     * The account waiting for its code.
     */
    public function pendingUser(): ?User
    {
        $userId = $this->session()->get(SignInService::PendingUserKey);

        return $this->pendingUser ??= is_int($userId) ? User::find($userId) : null;
    }

    /**
     * The account waiting for its code, once authorized.
     */
    public function signingInUser(): User
    {
        return $this->pendingUser() ?? throw new LogicException('No pending sign-in.');
    }
}
