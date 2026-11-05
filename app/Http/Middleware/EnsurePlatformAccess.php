<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default middleware of the platform section (routes/platform.php).
 *
 * Guests are redirected to the login page. Any authenticated user may currently
 * enter; platform access rules belong in handle(), after authentication.
 */
class EnsurePlatformAccess extends Authenticate
{
    /**
     * Ensure the user is authenticated and allowed to access the platform.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, ...$guards): Response
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
