<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — /{locale}/...
|--------------------------------------------------------------------------
|
| Server-side rendered pages that need no authentication. Every route here
| runs through HandlePublicRequests (see routes/web.php). Route names have
| no prefix ("home"), since "public" is a reserved word in JavaScript.
|
*/

Route::inertia('/', 'Welcome')->name('home');
