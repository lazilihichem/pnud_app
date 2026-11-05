<?php

namespace App\Http\Requests\Accounts\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RedirectToHomeRequest extends FormRequest
{
    /**
     * Any signed-in user has a home.
     */
    public function authorize(): bool
    {
        return $this->user() instanceof User;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * The signed-in user (typed for the controller).
     *
     * @param  string|null  $guard
     */
    public function user($guard = null): ?User
    {
        $user = parent::user($guard);

        return $user instanceof User ? $user : null;
    }
}
