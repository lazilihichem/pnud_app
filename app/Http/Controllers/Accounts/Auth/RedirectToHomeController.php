<?php

namespace App\Http\Controllers\Accounts\Auth;

use App\Enums\ProfileType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Auth\RedirectToHomeRequest;
use Illuminate\Http\RedirectResponse;

class RedirectToHomeController extends Controller
{
    /**
     * Send a signed-in user to the home page of their profile (FR-01 step 5, FR-02 step 4).
     *
     * The single place deciding where each profile lands: sign-in, registration, the
     * authenticator-app step and « already signed in » redirects all come through here.
     */
    public function __invoke(RedirectToHomeRequest $request): RedirectResponse
    {
        return to_route(match ($request->user()->type) {
            ProfileType::Admin => 'admin.home',
            ProfileType::Entrepreneur => 'platform.entrepreneur.home',
            ProfileType::Accompagnateur => 'platform.accompagnateur.home',
            ProfileType::Formateur => 'platform.formateur.home',
            ProfileType::Citoyen => 'platform.citoyen.home',
        });
    }
}
