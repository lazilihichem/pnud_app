<?php

namespace App\Http\Requests\Accounts;

use App\Concerns\PasswordValidationRules;
use App\Enums\UserRole;
use App\Models\Reference\Wilaya;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * « Créer un compte » (FR-01). Fields of a profile other than the chosen one are excluded, never stored.
 */
class RegisterAccountRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * Only signed-out visitors can register.
     */
    public function authorize(): bool
    {
        return $this->user() === null;
    }

    /**
     * Normalise the e-mail: one account per address, whatever its case.
     */
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('email'))) {
            $this->merge(['email' => mb_strtolower(trim($this->input('email')))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $accompagnateur = UserRole::Accompagnateur->value;
        $formateur = UserRole::Formateur->value;

        return [
            'role' => ['required', Rule::enum(UserRole::class)->only(UserRole::selfRegistrable())],
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:254', Rule::unique(User::class, 'email')],
            'organisation' => ['nullable', 'string', 'max:150'],
            'wilaya_id' => ['required', 'integer', Rule::exists(Wilaya::class, 'id')],
            'fonction' => ["exclude_unless:role,{$accompagnateur}", 'required', 'string', 'max:150'],
            'linkedin_url' => ["exclude_unless:role,{$formateur}", 'nullable', 'string', 'url:https', 'max:300'],
            'education' => ["exclude_unless:role,{$formateur}", 'required', 'string', 'max:300'],
            'cv' => ["exclude_unless:role,{$formateur}", 'required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'password' => $this->passwordRules(),
            'terms' => ['accepted'],
        ];
    }

    /**
     * The validated registration, typed for the service.
     *
     * @return array{role: string, name: string, email: string, password: string, organisation?: ?string, wilaya_id: int, fonction?: string, linkedin_url?: ?string, education?: string, cv?: UploadedFile}
     */
    public function registration(): array
    {
        /** @var array{role: string, name: string, email: string, password: string, organisation?: ?string, wilaya_id: int, fonction?: string, linkedin_url?: ?string, education?: string, cv?: UploadedFile} $data */
        $data = $this->validated();

        return $data;
    }

    /**
     * Get the SRS messages for the edge cases of FR-01.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => __('accounts.registration.required'),
            'terms.accepted' => __('accounts.registration.required'),
            'email.unique' => __('accounts.registration.email_taken'),
            'password.confirmed' => __('accounts.registration.passwords_differ'),
            'cv.mimes' => __('accounts.registration.cv_format'),
            'cv.max' => __('accounts.registration.cv_format'),
            'cv.file' => __('accounts.registration.cv_format'),
        ];
    }

    /**
     * Get the screen labels of the fields.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return __('accounts.attributes');
    }
}
