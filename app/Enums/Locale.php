<?php

namespace App\Enums;

use App\Models\User;

/**
 * The interface languages, carried in the URL path as /public/{locale}/… and /platform/{locale}/… (SRS FR-06).
 */
enum Locale: string
{
    case French = 'fr';
    case Arabic = 'ar';

    /**
     * The cookie remembering the visitor's last language.
     */
    public const string Cookie = 'locale';

    /**
     * How long the language cookie lives, in minutes (12 months).
     */
    public const int CookieLifetime = 60 * 24 * 365;

    /**
     * The route constraint matching every supported locale.
     */
    public static function pattern(): string
    {
        return implode('|', array_column(self::cases(), 'value'));
    }

    /**
     * Pick the language for a URL without one: the account language, then the cookie, then French.
     */
    public static function preferredFor(?User $user, ?string $cookie): self
    {
        return $user->locale ?? self::tryFrom((string) $cookie) ?? self::French;
    }

    /**
     * Whether the language is written right to left.
     */
    public function isRightToLeft(): bool
    {
        return $this === self::Arabic;
    }
}
