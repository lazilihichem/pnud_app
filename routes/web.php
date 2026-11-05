<?php

use App\Http\Middleware\EnsureAdminAccess;
use App\Http\Middleware\EnsurePlatformAccess;
use App\Http\Middleware\HandlePublicRequests;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (Request $request) => redirect('/'.SetLocale::resolveLocale($request)))
    ->name('locale.redirect');

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('platform.security.edit'),
        'manage' => route('platform.security.edit'),
    ]);
})->name('well-known.passkeys');

// Authentication pages (/{locale}/login, ...) are registered by Fortify (config/fortify.php).
Route::prefix('{locale}')->group(function () {
    // Platform and admin come first so a future public catch-all route
    // such as /{locale}/{slug} cannot capture /{locale}/platform/...
    Route::prefix('platform')
        ->name('platform.')
        ->middleware(EnsurePlatformAccess::class)
        ->group(base_path('routes/platform.php'));

    Route::prefix('admin')
        ->name('admin.')
        ->middleware(EnsureAdminAccess::class)
        ->group(base_path('routes/admin.php'));

    Route::middleware(HandlePublicRequests::class)
        ->group(base_path('routes/public.php'));
});
