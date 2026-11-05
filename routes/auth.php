<?php

use App\Http\Controllers\Accounts\Auth\RegistrationResourceController;
use App\Http\Controllers\Accounts\Auth\ResendSignInCodeController;
use App\Http\Controllers\Accounts\Auth\SignInCodeResourceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes — /{locale}/...
|--------------------------------------------------------------------------
|
| The application's own authentication pages, next to Fortify's (login,
| password reset, verification). Every route here runs through the guest
| middleware (see routes/web.php) and is client-rendered (no SSR).
|
*/

// Accounts — FR-01 registration (moved out of Fortify).
Route::get('register', [RegistrationResourceController::class, 'create'])->name('register');
Route::post('register', [RegistrationResourceController::class, 'store'])->name('register.store');

// Accounts — FR-02 e-mail code step; the password step is Fortify's POST /{locale}/login.
Route::get('login/code', [SignInCodeResourceController::class, 'create'])->name('login.code');
Route::post('login/code', [SignInCodeResourceController::class, 'store'])->middleware('throttle:10,1')->name('login.code.verify');
Route::delete('login/code', [SignInCodeResourceController::class, 'destroy'])->name('login.code.cancel');
Route::post('login/code/resend', ResendSignInCodeController::class)->middleware('throttle:10,1')->name('login.code.resend');
