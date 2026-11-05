<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use App\Services\Accounts\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(private UserService $userService) {}

    /**
     * Apply the language of the URL, or the preferred one on routes without a {locale} segment.
     *
     * A localized URL also refreshes the language cookie and the signed-in user's account language.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $routeLocale = $route?->parameter('locale');
        $cookie = $request->cookie(Locale::Cookie);
        $urlLocale = is_string($routeLocale) ? Locale::tryFrom($routeLocale) : null;
        $locale = $urlLocale ?? Locale::preferredFor($request->user(), is_string($cookie) ? $cookie : null);

        App::setLocale($locale->value);
        URL::defaults(['locale' => $locale->value]);

        if ($urlLocale === null) {
            return $next($request);
        }

        $route->forgetParameter('locale');

        if ($request->user() !== null) {
            $this->userService->updateLocale($request->user(), $urlLocale);
        }

        Cookie::queue(Locale::Cookie, $urlLocale->value, Locale::CookieLifetime);

        return $next($request);
    }
}
