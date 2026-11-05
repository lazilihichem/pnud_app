<?php

namespace App\Http\Responses\Accounts;

use App\Models\User;
use App\Services\Accounts\Auth\SignInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse;

/**
 * A passkey replaces the password, never the e-mail code (FR-02: no bypass): the session the
 * passkey opened is closed again and the user continues to the code step.
 */
class PasskeySignInResponse implements PasskeyLoginResponse
{
    public function __construct(private SignInService $signInService) {}

    /**
     * Turn the passkey sign-in into the start of the e-mail-code step.
     *
     * @param  Request  $request
     */
    public function toResponse($request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();

        Auth::logout();

        if ($user instanceof User) {
            $this->signInService->start($user);

            $request->session()->put([
                SignInService::PendingUserKey => $user->id,
                SignInService::PendingRememberKey => $this->signInService->mayRemember($user, $request->boolean('remember')),
            ]);
        }

        if ($request->wantsJson()) {
            return new JsonResponse(['redirect' => route('login.code')]);
        }

        return to_route('login.code');
    }
}
