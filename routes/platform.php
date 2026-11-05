<?php

use App\Http\Controllers\Accounts\DeleteAccountController;
use App\Http\Controllers\Accounts\EditProfileController;
use App\Http\Controllers\Accounts\EditSecurityController;
use App\Http\Controllers\Accounts\UpdatePasswordController;
use App\Http\Controllers\Accounts\UpdateProfileController;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Platform Routes — /{locale}/platform/...
|--------------------------------------------------------------------------
|
| Pages for signed-in users. Every route here runs through EnsurePlatformAccess
| (see routes/web.php) and is named "platform.*".
|
*/

Route::get('settings', fn () => to_route('platform.profile.edit'))->name('settings');

// Accounts
Route::get('settings/profile', EditProfileController::class)->name('profile.edit');
Route::patch('settings/profile', UpdateProfileController::class)->name('profile.update');

Route::middleware('verified')->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::delete('settings/profile', DeleteAccountController::class)->name('profile.destroy');

    Route::get('settings/security', EditSecurityController::class)
        ->middleware(RequirePassword::class)
        ->name('security.edit');

    Route::put('settings/password', UpdatePasswordController::class)
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::inertia('settings/appearance', 'settings/Appearance')->name('appearance.edit');
});
