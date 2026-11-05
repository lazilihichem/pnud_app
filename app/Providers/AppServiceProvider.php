<?php

namespace App\Providers;

use App\Http\Middleware\HandlePublicRequests;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureServerSideRendering();
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
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
