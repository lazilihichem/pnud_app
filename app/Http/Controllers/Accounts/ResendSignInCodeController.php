<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\ResendSignInCodeRequest;
use App\Services\Accounts\SignInCodeService;
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
