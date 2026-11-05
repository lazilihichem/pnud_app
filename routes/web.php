<?php

use App\Enums\Locale;
use App\Http\Controllers\Accounts\DeleteAccountController;
use App\Http\Controllers\Accounts\EditProfileController;
use App\Http\Controllers\Accounts\EditSecurityController;
use App\Http\Controllers\Accounts\RegisterAccountController;
use App\Http\Controllers\Accounts\ShowRegistrationController;
use App\Http\Controllers\Accounts\UpdatePasswordController;
use App\Http\Controllers\Accounts\UpdateProfileController;
use App\Http\Controllers\Operations\RedirectToLocaleController;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Areas
|--------------------------------------------------------------------------
|
| /public/{locale}/…    public portal, server-rendered (SSR), open to visitors
| /platform/{locale}/…  member spaces of signed-in users, client-rendered
|
| Auth pages (Fortify) stay unprefixed. A URL without a locale redirects to
| the same path in the preferred language (account, cookie, then French).
|
*/

$withoutLocale = '(?!(?:'.Locale::pattern().')(?:/|$)).*';

Route::get('/', RedirectToLocaleController::class)->defaults('area', 'public');

/*
|--------------------------------------------------------------------------
| Auth pages (unprefixed, next to Fortify's)
|--------------------------------------------------------------------------
*/

// Accounts
Route::middleware('guest')->group(function () {
    Route::get('register', ShowRegistrationController::class)->name('register');
    Route::post('register', RegisterAccountController::class)->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Public portal
|--------------------------------------------------------------------------
*/

Route::prefix('public/{locale}')
    ->where(['locale' => Locale::pattern()])
    ->name('public.')
    ->group(function () {
        Route::inertia('/', 'Welcome')->name('home');
    });

/*
|--------------------------------------------------------------------------
| Platform
|--------------------------------------------------------------------------
*/

Route::prefix('platform/{locale}')
    ->where(['locale' => Locale::pattern()])
    ->name('platform.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', fn () => to_route('platform.dashboard'))->name('home');

        Route::middleware('verified')->group(function () {
            Route::inertia('dashboard', 'Dashboard')->name('dashboard');
        });

        // Accounts
        Route::get('settings', fn () => to_route('platform.profile.edit'));

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

            Route::inertia('settings/appearance', 'settings/Appearance')->name('appearance.edit');
        });
    });

/*
|--------------------------------------------------------------------------
| URLs without a locale
|--------------------------------------------------------------------------
*/

Route::get('public/{path?}', RedirectToLocaleController::class)
    ->where('path', $withoutLocale)
    ->defaults('area', 'public');

Route::get('platform/{path?}', RedirectToLocaleController::class)
    ->where('path', $withoutLocale)
    ->defaults('area', 'platform');

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('platform.security.edit'),
        'manage' => route('platform.security.edit'),
    ]);
})->name('well-known.passkeys');
