<?php

namespace App\Actions\Fortify;

use App\Services\Accounts\Auth\SignInService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;

/**
 * Fortify login pipeline step (FR-02): the password only opens the e-mail-code step.
 */
class StartSignInWithCode
{
    public function __construct(private SignInService $signInService) {}

    /**
     * Check the password, send the code and wait for it on the code page.
     *
     * @param  Closure(Request): mixed  $next
     */
    public function handle(Request $request, Closure $next): RedirectResponse
    {
        $user = $this->signInService->attempt(
            (string) $request->input(Fortify::username()),
            (string) $request->input('password'),
            (string) $request->ip(),
        );

        $request->session()->put([
            SignInService::PendingUserKey => $user->id,
            SignInService::PendingRememberKey => $this->signInService->mayRemember($user, $request->boolean('remember')),
        ]);

        return to_route('login.code');
    }
}
