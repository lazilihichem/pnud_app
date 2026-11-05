<?php

namespace App\Http\Controllers\Accounts;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\ShowRegistrationRequest;
use App\Services\Reference\WilayaService;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class ShowRegistrationController extends Controller
{
    public function __construct(private WilayaService $wilayaService) {}

    /**
     * Show the « Créer un compte » form (FR-01).
     */
    public function __invoke(ShowRegistrationRequest $request): Response
    {
        return Inertia::render('auth/Register', [
            'roles' => array_map(fn (UserRole $role): array => [
                'value' => $role->value,
                'label' => __("accounts.roles.{$role->value}"),
            ], UserRole::selfRegistrable()),
            'wilayas' => $this->wilayaService->options(),
            'passwordRules' => Password::defaults()->toPasswordRulesString(),
        ]);
    }
}
