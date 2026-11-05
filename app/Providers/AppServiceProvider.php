<?php

namespace App\Providers;

use App\Enums\Locale;
use App\Enums\ProfileType;
use App\Http\Middleware\HandlePublicRequests;
use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
use App\Services\Accounts\Auth\SignInCodeService;
use App\Services\Accounts\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registered before any provider boots, so it also applies to Fortify's routes.
        $this->configureLocaleRoutes();

        // Telescope is a dev dependency (not discovered automatically): local environment only.
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureMorphMap();
        $this->configureServerSideRendering();
        $this->configureSignIn();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        // Member accounts: 8–64 characters with at least one letter and one digit (FR-01, FR-03).
        // No breached-password lookup: no foreign service may receive platform data (SRS 5.5).
        Password::defaults(fn (): Password => Password::min(8)->max(64)->letters()->numbers());
    }

    /**
     * Polymorphic columns store aliases, never class names: the account profiles
     * (ProfileType values) and the user. Every new polymorphic owner (media, …) must be added.
     */
    protected function configureMorphMap(): void
    {
        Relation::enforceMorphMap([
            ...ProfileType::morphMap(),
            'user' => User::class,
        ]);
    }

    /**
     * Server-side render only the public pages (requests marked by HandlePublicRequests).
     *
     * The condition is evaluated per response, and a registered condition replaces the
     * inertia.ssr.enabled config check, so that setting is honoured here as well.
     */
    protected function configureServerSideRendering(): void
    {
        Inertia::disableSsr(fn (): bool => ! config('inertia.ssr.enabled')
            || request()->attributes->get(HandlePublicRequests::SSR_ATTRIBUTE) !== true);
    }

    /**
     * Restrict every {locale} route segment (including Fortify's) to the supported locales.
     */
    protected function configureLocaleRoutes(): void
    {
        /** @var list<string> $supportedLocales */
        $supportedLocales = config('app.supported_locales');

        Route::pattern('locale', implode('|', array_map(preg_quote(...), $supportedLocales)));
    }

    /**
     * Sign-in side effects (FR-02, FR-06): a code's 5 minutes start at delivery; every completed
     * sign-in is stored as « Dernière connexion » and makes the language in use the account language.
     */
    protected function configureSignIn(): void
    {
        Event::listen(function (NotificationSent $event): void {
            if ($event->notification instanceof SignInCodeNotification) {
                app(SignInCodeService::class)->markDelivered($event->notification->signInCode);
            }
        });

        Event::listen(function (Login $event): void {
            if (! $event->user instanceof User) {
                return;
            }

            // A passkey only replaces the password: its session is closed again before the e-mail code
            // step (PasskeySignInResponse), so it is not a completed sign-in.
            if (request()->routeIs('passkey.login')) {
                return;
            }

            $userService = app(UserService::class);
            $userService->recordSignIn($event->user);

            // A remember-me cookie restores the user while SetLocale is still resolving the locale,
            // so the app locale is only the default here: keep the stored account language.
            if (Auth::guard($event->guard)->viaRemember()) {
                return;
            }

            $locale = Locale::tryFrom(App::getLocale());

            if ($locale !== null) {
                $userService->updateLocale($event->user, $locale);
            }
        });
    }
}
