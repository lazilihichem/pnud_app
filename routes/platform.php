<?php

use App\Http\Controllers\Accounts\Auth\RedirectToHomeController;
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

// Accounts — the profile's home: /{locale}/platform sends each profile to its own page.
Route::get('/', RedirectToHomeController::class)->name('home');

// The starter-kit dashboard is gone: old links land on the profile's home.
Route::get('dashboard', fn () => to_route('platform.home'))->name('dashboard');

// Each profile's member space: only that profile may enter (FR-04, « Accès réservé » 403).
// Pages of a profile go inside its group.
Route::prefix('entrepreneur')->name('entrepreneur.')->middleware('profile:entrepreneur')->group(function () {
    Route::inertia('/', 'platform/entrepreneur/Home')->name('home');
});

Route::prefix('accompagnateur')->name('accompagnateur.')->middleware('profile:accompagnateur')->group(function () {
    Route::inertia('/', 'platform/accompagnateur/Home')->name('home');
});

Route::prefix('formateur')->name('formateur.')->middleware('profile:formateur')->group(function () {
    Route::inertia('/', 'platform/formateur/Home')->name('home');
});

Route::prefix('citoyen')->name('citoyen.')->middleware('profile:citoyen')->group(function () {
    Route::inertia('/', 'platform/citoyen/Home')->name('home');
});

Route::get('settings', fn () => to_route('platform.profile.edit'))->name('settings');

// Accounts
Route::get('settings/profile', EditProfileController::class)->name('profile.edit');
Route::patch('settings/profile', UpdateProfileController::class)->name('profile.update');

Route::middleware('verified')->group(function () {
    Route::delete('settings/profile', DeleteAccountController::class)->name('profile.destroy');

    Route::get('settings/security', EditSecurityController::class)
        ->middleware(RequirePassword::class)
        ->name('security.edit');

    Route::put('settings/password', UpdatePasswordController::class)
        ->middleware('throttle:6,1')
        ->name('user-password.update');

});
