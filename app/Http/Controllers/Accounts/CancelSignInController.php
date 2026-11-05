<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\CancelSignInRequest;
use App\Services\Accounts\SignInService;
use Illuminate\Http\RedirectResponse;

class CancelSignInController extends Controller
{
    /**
     * « Utiliser un autre compte »: drop the pending sign-in and go back to the sign-in page.
     */
    public function __invoke(CancelSignInRequest $request): RedirectResponse
    {
        $request->session()->forget([SignInService::PendingUserKey, SignInService::PendingRememberKey]);

        return to_route('login');
    }
}
