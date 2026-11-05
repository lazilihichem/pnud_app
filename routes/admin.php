<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes — /{locale}/admin/...
|--------------------------------------------------------------------------
|
| Administration pages. Every route here runs through EnsureAdminAccess
| (see routes/web.php) and is named "admin.*".
|
*/

// Accounts — the back-office home of administrators and super administrators.
Route::inertia('/', 'admin/Home')->name('home');
