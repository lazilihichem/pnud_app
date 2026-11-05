<?php

namespace App\Http\Controllers\Accounts\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Auth\ResendSignInCodeRequest;
use App\Services\Accounts\Auth\SignInCodeService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ResendSignInCodeController extends Controller
{
    public function __construct(private SignInCodeService $signInCodeService) {}

    /**
     * « Renvoyer le code » (FR-02).
     */
    public function __invoke(ResendSignInCodeRequest $request): RedirectResponse
    {
        $this->signInCodeService->resend($request->signingInUser());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('accounts.sign_in.code_sent')]);

        return to_route('login.code');
    }
}
