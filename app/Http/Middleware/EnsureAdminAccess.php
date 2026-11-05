<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default middleware of the admin section (routes/admin.php).
 *
 * Guests are redirected to the login page. Any authenticated user may currently
 * enter; admin access rules belong in handle(), after authentication.
 */
class EnsureAdminAccess extends Authenticate
{
    /**
     * Ensure the user is authenticated and allowed to access the admin area.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, ...$guards): Response
    {
        $this->authenticate($request, $guards);

        // The back-office is for administrators and super administrators only (« Accès réservé »).
        abort_unless($request->user() instanceof User && $request->user()->isAdministrator(), 403);

        return $next($request);
    }
}
