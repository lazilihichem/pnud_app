<?php

use App\Http\Controllers\Accounts\CancelSignInController;
use App\Http\Controllers\Accounts\RegisterAccountController;
use App\Http\Controllers\Accounts\ResendSignInCodeController;
use App\Http\Controllers\Accounts\ShowRegistrationController;
use App\Http\Controllers\Accounts\ShowSignInCodeController;
use App\Http\Controllers\Accounts\VerifySignInCodeController;
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
Route::get('register', ShowRegistrationController::class)->name('register');
Route::post('register', RegisterAccountController::class)->name('register.store');

// Accounts — FR-02 e-mail code step; the password step is Fortify's POST /{locale}/login.
Route::get('login/code', ShowSignInCodeController::class)->name('login.code');
Route::post('login/code', VerifySignInCodeController::class)->middleware('throttle:10,1')->name('login.code.verify');
Route::post('login/code/resend', ResendSignInCodeController::class)->middleware('throttle:10,1')->name('login.code.resend');
Route::post('login/code/cancel', CancelSignInController::class)->name('login.code.cancel');
