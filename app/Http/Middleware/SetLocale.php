<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * The session key holding the visitor's last used locale.
     */
    public const string SESSION_KEY = 'locale';

    /**
     * Resolve the request locale, apply it to the app and use it as the default {locale} URL parameter.
     *
     * The locale comes from the `{locale}` route segment when present (e.g. /ar/dashboard).
     * Routes without that segment (passkey JSON endpoints, the root redirect) fall back to the
     * last locale stored in the session, then the visitor's browser preference.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        if ($request->hasSession()) {
            $request->session()->put(self::SESSION_KEY, $locale);
        }

        // Fortify reads its redirect paths at response time; keep them in the current locale.
        config([
            'fortify.home' => "/{$locale}/dashboard",
            'fortify.redirects.logout' => "/{$locale}",
        ]);

        // Controllers shouldn't receive {locale} as their first route argument.
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }

    /**
     * Determine which supported locale applies to the request.
     */
    public static function resolveLocale(Request $request): string
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.supported_locales');

        $routeLocale = $request->route('locale');

        if (is_string($routeLocale) && in_array($routeLocale, $supportedLocales, true)) {
            return $routeLocale;
        }

        $sessionLocale = $request->hasSession() ? $request->session()->get(self::SESSION_KEY) : null;

        if (is_string($sessionLocale) && in_array($sessionLocale, $supportedLocales, true)) {
            return $sessionLocale;
        }

        $preferredLocale = $request->getPreferredLanguage($supportedLocales);

        if (is_string($preferredLocale) && in_array($preferredLocale, $supportedLocales, true)) {
            return $preferredLocale;
        }

        $defaultLocale = config('app.locale');

        return is_string($defaultLocale) && in_array($defaultLocale, $supportedLocales, true)
            ? $defaultLocale
            : $supportedLocales[0];
    }
}
