import { createI18n } from 'vue-i18n';
import type { PickupPaths } from 'vue-i18n';
import ar from '@/i18n/locales/ar.json';
import fr from '@/i18n/locales/fr.json';
import { setUrlDefaults } from '@/wayfinder';

/**
 * French is the master schema: every other locale must define the same keys.
 */
export type MessageSchema = typeof fr;

/**
 * Any valid translation key, e.g. 'nav.dashboard'.
 */
export type TranslationKey = PickupPaths<MessageSchema>;

export const locales = ['fr', 'ar'] as const;

export type Locale = (typeof locales)[number];

export type Direction = 'ltr' | 'rtl';

const rtlLocales: readonly Locale[] = ['ar'];

const defaultLocale: Locale = 'fr';

const messages: Record<Locale, MessageSchema> = { fr, ar };

export function isLocale(value: unknown): value is Locale {
    return (
        typeof value === 'string' &&
        (locales as readonly string[]).includes(value)
    );
}

export function directionFor(locale: Locale): Direction {
    return rtlLocales.includes(locale) ? 'rtl' : 'ltr';
}

/**
 * The server renders <html lang="…"> from the /{locale} URL segment, so it is
 * the source of truth before any page or route module is evaluated.
 */
function documentLocale(): Locale {
    const lang =
        typeof document === 'undefined' ? null : document.documentElement.lang;

    return isLocale(lang) ? lang : defaultLocale;
}

export const currentLocale: Locale = documentLocale();

export const currentDirection: Direction = directionFor(currentLocale);

export const i18n = createI18n<[MessageSchema], Locale, false>({
    legacy: false,
    locale: currentLocale,
    fallbackLocale: defaultLocale,
    messages,
});

// Every Wayfinder route function fills {locale} from the current locale.
setUrlDefaults({ locale: currentLocale });

/**
 * Build the URL of the current page in another locale (/fr/settings → /ar/settings).
 */
export function localizedUrl(locale: Locale, url: string): string {
    const [path, ...rest] = url.split(/(?=[?#])/);
    const segments = (path ?? '/').split('/');

    if (isLocale(segments[1])) {
        segments[1] = locale;
    } else {
        segments.splice(1, 0, locale);
    }

    return segments.join('/').replace(/\/$/, '') + rest.join('');
}
