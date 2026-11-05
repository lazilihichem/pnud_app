<?php

namespace App\Http\Controllers\Accounts\Auth;

use App\Enums\Locale;
use App\Enums\ProfileType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Auth\CreateRegistrationRequest;
use App\Http\Requests\Accounts\Auth\StoreRegistrationRequest;
use App\Services\Accounts\UserService;
use App\Services\Reference\WilayaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Account registration (FR-01), as a resource: create = the form, store = registering.
 */
class RegistrationResourceController extends Controller
{
    public function __construct(
        private UserService $userService,
        private WilayaService $wilayaService,
    ) {}

    /**
     * Show the « Créer un compte » form.
     */
    public function create(CreateRegistrationRequest $request): Response
    {
        return Inertia::render('auth/Register', [
            'roles' => array_map(fn (ProfileType $type): array => [
                'value' => $type->value,
                'label' => __("accounts.roles.{$type->value}"),
            ], ProfileType::selfRegistrable()),
            'wilayas' => $this->wilayaService->options(),
            'passwordRules' => Password::defaults()->toPasswordRulesString(),
        ]);
    }

    /**
     * Create the account, sign the user in and send them to their role's home.
     */
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $user = $this->userService->register($request->registration(), Locale::from(App::getLocale()));

        Auth::login($user);
        $request->session()->regenerate();

        return to_route('platform.home');
    }
}
