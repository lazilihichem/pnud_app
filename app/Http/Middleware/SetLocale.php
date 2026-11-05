<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use App\Models\User;
use App\Services\Accounts\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * The session key holding the visitor's last used locale.
     */
    public const string SESSION_KEY = 'locale';

    /**
     * The cookie remembering the visitor's language for 12 months (SRS FR-06).
     */
    public const string COOKIE = 'locale';

    /**
     * How long the language cookie lives, in minutes (12 months).
     */
    public const int COOKIE_MINUTES = 60 * 24 * 365;

    public function __construct(private UserService $userService) {}

    /**
     * Resolve the request locale, apply it to the app and use it as the default {locale} URL parameter.
     *
     * The locale comes from the `{locale}` route segment when present (e.g. /ar/dashboard).
     * Routes without that segment (passkey JSON endpoints, the root redirect) fall back to the
     * signed-in user's account language, the language cookie, the session, then the browser.
     *
     * A `{locale}` URL is a language choice (FR-06): it is remembered in the cookie for 12 months
     * and becomes the signed-in user's account language (e-mails, notifications).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = self::resolveLocale($request);

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        if ($request->hasSession()) {
            $request->session()->put(self::SESSION_KEY, $locale);
        }

        if (self::routeLocale($request) !== null) {
            Cookie::queue(self::COOKIE, $locale, self::COOKIE_MINUTES);

            $user = $request->user();

            if ($user instanceof User) {
                $this->userService->updateLocale($user, Locale::from($locale));
            }
        }

        // Fortify reads its redirect paths at response time; keep them in the current locale.
        config([
            'fortify.home' => "/{$locale}/platform",
            'fortify.redirects.logout' => "/{$locale}",
        ]);

        // Controllers shouldn't receive {locale} as their first route argument.
        $request->route()?->forgetParameter('locale');

        return $next($request);
    }

    /**
     * Determine which supported locale applies to the request: the URL, the account language,
     * the 12-month cookie, the session, the browser preference, then the default.
     */
    public static function resolveLocale(Request $request): string
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.supported_locales');

        $user = $request->user();
        $cookie = $request->cookie(self::COOKIE);

        $candidates = [
            self::routeLocale($request),
            $user instanceof User ? $user->locale->value : null,
            is_string($cookie) ? $cookie : null,
            $request->hasSession() ? $request->session()->get(self::SESSION_KEY) : null,
            $request->getPreferredLanguage($supportedLocales),
            config('app.locale'),
        ];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && in_array($candidate, $supportedLocales, true)) {
                return $candidate;
            }
        }

        return $supportedLocales[0];
    }

    /**
     * The supported locale carried by the `{locale}` route segment, if any.
     */
    private static function routeLocale(Request $request): ?string
    {
        $routeLocale = $request->route('locale');

        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.supported_locales');

        return is_string($routeLocale) && in_array($routeLocale, $supportedLocales, true) ? $routeLocale : null;
    }
}
