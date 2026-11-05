<?php

namespace App\Http\Requests\Accounts\Auth;

use Illuminate\Contracts\Validation\ValidationRule;

class DestroySignInCodeRequest extends PendingSignInRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
