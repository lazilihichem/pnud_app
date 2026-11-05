<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default middleware of the public section (routes/public.php).
 *
 * Public pages need no authentication and are server-side rendered: SSR is opt-in
 * (see AppServiceProvider) and only requests passing through here enable it.
 */
class HandlePublicRequests
{
    /**
     * The request attribute that enables server-side rendering for the response.
     */
    public const string SSR_ATTRIBUTE = 'inertia.ssr';

    /**
     * Mark the request as a server-side rendered public page.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set(self::SSR_ATTRIBUTE, true);

        return $next($request);
    }
}
