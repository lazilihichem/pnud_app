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

export const defaultLocale: Locale = 'fr';

const rtlLocales: readonly Locale[] = ['ar'];

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
 * Create the vue-i18n instance for one app (one page load, or one SSR render).
 */
export function createAppI18n(locale: Locale) {
    return createI18n<[MessageSchema], Locale, false>({
        legacy: false,
        locale,
        fallbackLocale: defaultLocale,
        messages,
    });
}

/**
 * In the browser, the server-rendered <html lang="…"> (from the /{locale} URL
 * segment) is known before any page or route module is evaluated.
 */
export function documentLocale(): Locale {
    const lang =
        typeof document === 'undefined' ? null : document.documentElement.lang;

    return isLocale(lang) ? lang : defaultLocale;
}

let resolveActiveLocale: () => Locale = documentLocale;

/**
 * Replace how the active locale is resolved. The SSR server uses this to scope
 * the locale to each render request.
 */
export function setActiveLocaleResolver(resolver: () => Locale): void {
    resolveActiveLocale = resolver;
}

// Every Wayfinder route function fills {locale} from the active locale. This runs
// when the module is first imported, before any page module builds a route URL.
setUrlDefaults(() => ({ locale: resolveActiveLocale() }));

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
