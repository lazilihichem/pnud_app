<?php

namespace App\Http\Requests\Accounts;

use Illuminate\Contracts\Validation\ValidationRule;

class VerifySignInCodeRequest extends PendingSignInRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'digits:6'],
        ];
    }

    /**
     * Get the screen labels of the fields.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ['code' => 'code de vérification'];
    }
}
