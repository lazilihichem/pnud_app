<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\UpdateProfileRequest;
use App\Services\Accounts\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class UpdateProfileController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Update the user's profile information.
     */
    public function __invoke(UpdateProfileRequest $request): RedirectResponse
    {
        $this->userService->updateProfile($request->user(), $request->profile());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Profile updated.')]);

        return to_route('platform.profile.edit');
    }
}
