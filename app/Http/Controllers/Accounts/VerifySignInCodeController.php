<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\VerifySignInCodeRequest;
use App\Services\Accounts\SignInCodeService;
use App\Services\Accounts\SignInService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifySignInCodeController extends Controller
{
    public function __construct(private SignInCodeService $signInCodeService) {}

    /**
     * Check the e-mail code and complete the sign-in (FR-02); an account that also set up an
     * authenticator app continues to Fortify's TOTP challenge.
     */
    public function __invoke(VerifySignInCodeRequest $request): RedirectResponse
    {
        $user = $request->signingInUser();

        $this->signInCodeService->verify($user, $request->validated('code'));

        $remember = (bool) $request->session()->pull(SignInService::PendingRememberKey, false);
        $request->session()->forget(SignInService::PendingUserKey);

        if ($user->hasConfirmedTwoFactor()) {
            $request->session()->put(['login.id' => $user->id, 'login.remember' => $remember]);

            return to_route('two-factor.login');
        }

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route($user->role->homeRoute()));
    }
}
