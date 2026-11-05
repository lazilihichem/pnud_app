<?php

namespace App\Http\Controllers\Accounts;

use App\Enums\Locale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\RegisterAccountRequest;
use App\Services\Accounts\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class RegisterAccountController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Create the account, sign the user in and send them to their role's home (FR-01).
     */
    public function __invoke(RegisterAccountRequest $request): RedirectResponse
    {
        $user = $this->userService->register($request->registration(), Locale::from(App::getLocale()));

        Auth::login($user);
        $request->session()->regenerate();

        return to_route($user->role->homeRoute());
    }
}
