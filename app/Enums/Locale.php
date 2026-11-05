<?php

namespace App\Enums;

/**
 * An account language (ERD: users.locale, SRS FR-06): e-mails and notifications are sent in it.
 * The supported interface locales are listed in config('app.supported_locales').
 */
enum Locale: string
{
    case French = 'fr';
    case Arabic = 'ar';
}
