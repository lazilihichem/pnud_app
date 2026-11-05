<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Member-space pages open only for the profiles they belong to (SRS FR-04): any other
 * profile receives « Accès réservé » (HTTP 403). Usage: `->middleware('profile:formateur')`,
 * several types allowed: `profile:entrepreneur,citoyen`.
 */
class EnsureProfileType
{
    /**
     * Refuse the request unless the signed-in account has one of the given profile types.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        $user = $request->user();

        abort_unless($user instanceof User && in_array($user->type->value, $types, true), 403);

        return $next($request);
    }
}
