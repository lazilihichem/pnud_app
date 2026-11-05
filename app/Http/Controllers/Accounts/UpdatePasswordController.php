<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\UpdatePasswordRequest;
use App\Services\Accounts\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class UpdatePasswordController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Update the user's password.
     */
    public function __invoke(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->userService->updatePassword($request->user(), $request->validated('password'));

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Password updated.')]);

        return back();
    }
}
