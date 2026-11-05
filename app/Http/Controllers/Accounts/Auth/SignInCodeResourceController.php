<?php

namespace App\Http\Controllers\Accounts\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Auth\CreateSignInCodeRequest;
use App\Http\Requests\Accounts\Auth\DestroySignInCodeRequest;
use App\Http\Requests\Accounts\Auth\StoreSignInCodeRequest;
use App\Services\Accounts\Auth\SignInCodeService;
use App\Services\Accounts\Auth\SignInService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

/**
 * The e-mail code step of the sign-in (FR-02), as a resource: create = the code page,
 * store = entering the code, destroy = « Utiliser un autre compte ». Resending is its own
 * invokable controller (ResendSignInCodeController).
 */
class SignInCodeResourceController extends Controller
{
    public function __construct(private SignInCodeService $signInCodeService) {}

    /**
     * Show the « Code de vérification » step.
     */
    public function create(CreateSignInCodeRequest $request): Response
    {
        $user = $request->signingInUser();

        return Inertia::render('auth/SignInCode', [
            'email' => $user->maskedEmail(),
            'deliveryPending' => $this->signInCodeService->latestFor($user)?->isPendingDelivery() ?? false,
            'resendAvailableIn' => $this->signInCodeService->resendAvailableIn($user),
        ]);
    }

    /**
     * Check the e-mail code and complete the sign-in; an account that also set up an
     * authenticator app continues to Fortify's TOTP challenge.
     */
    public function store(StoreSignInCodeRequest $request): RedirectResponse
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

    /**
     * « Utiliser un autre compte »: drop the pending sign-in and go back to the sign-in page.
     */
    public function destroy(DestroySignInCodeRequest $request): RedirectResponse
    {
        $request->session()->forget([SignInService::PendingUserKey, SignInService::PendingRememberKey]);

        return to_route('login');
    }
}
