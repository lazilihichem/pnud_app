<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (Request $request) => redirect('/'.SetLocale::resolveLocale($request)))
    ->name('locale.redirect');

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('security.edit'),
        'manage' => route('security.edit'),
    ]);
})->name('well-known.passkeys');

Route::prefix('{locale}')->group(function () {
    Route::inertia('/', 'Welcome')->name('home');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    });

    require __DIR__.'/settings.php';
});
