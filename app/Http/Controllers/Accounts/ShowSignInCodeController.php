<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\ShowSignInCodeRequest;
use App\Services\Accounts\SignInCodeService;
use Inertia\Inertia;
use Inertia\Response;

class ShowSignInCodeController extends Controller
{
    public function __construct(private SignInCodeService $signInCodeService) {}

    /**
     * Show the « Code de vérification » step (FR-02).
     */
    public function __invoke(ShowSignInCodeRequest $request): Response
    {
        $user = $request->signingInUser();

        return Inertia::render('auth/SignInCode', [
            'email' => $user->maskedEmail(),
            'deliveryPending' => $this->signInCodeService->latestFor($user)?->isPendingDelivery() ?? false,
            'resendAvailableIn' => $this->signInCodeService->resendAvailableIn($user),
        ]);
    }
}
