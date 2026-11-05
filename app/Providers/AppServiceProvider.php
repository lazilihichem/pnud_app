<?php

namespace App\Providers;

use App\Enums\Locale;
use App\Models\User;
use App\Notifications\Accounts\SignInCodeNotification;
use App\Services\Accounts\SignInCodeService;
use App\Services\Accounts\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureLocalization();
        $this->configureSsr();
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
     * At sign-in, the language used just before becomes the account language (SRS FR-06).
     */
    protected function configureLocalization(): void
    {
        Event::listen(function (Login $event): void {
            $cookie = request()->cookie(Locale::Cookie);
            $locale = is_string($cookie) ? Locale::tryFrom($cookie) : null;

            if ($locale !== null && $event->user instanceof User) {
                app(UserService::class)->updateLocale($event->user, $locale);
            }
        });
    }

    /**
     * Server-render the public portal only; /platform and the auth pages render client-side.
     */
    protected function configureSsr(): void
    {
        Inertia::disableSsr(fn (): bool => ! request()->is('public', 'public/*'));
    }

    /**
     * Sign-in side effects: a code's 5 minutes start at delivery, and every completed
     * sign-in is stored as « Dernière connexion » (FR-02).
     */
    protected function configureSignIn(): void
    {
        Event::listen(function (NotificationSent $event): void {
            if ($event->notification instanceof SignInCodeNotification) {
                app(SignInCodeService::class)->markDelivered($event->notification->signInCode);
            }
        });

        Event::listen(function (Login $event): void {
            if ($event->user instanceof User) {
                app(UserService::class)->recordSignIn($event->user);
            }
        });
    }
}
