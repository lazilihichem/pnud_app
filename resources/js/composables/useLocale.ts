import { usePage } from '@inertiajs/vue3';
import type { ComputedRef } from 'vue';
import { computed } from 'vue';
import type { Direction, Locale } from '@/i18n';
import { localizedUrl } from '@/i18n';

export type LocaleLink = {
    locale: Locale;
    href: string;
};

export type UseLocaleReturn = {
    locale: ComputedRef<Locale>;
    direction: ComputedRef<Direction>;
    /** Links to the current page in every other locale. */
    alternateLocales: ComputedRef<LocaleLink[]>;
};

/**
 * The page locale and text direction, as shared by the server (SetLocale middleware).
 * Safe during SSR, unlike reading <html lang> from the document.
 */
export function useLocale(): UseLocaleReturn {
    const page = usePage();

    const locale = computed(() => page.props.locale);
    const direction = computed(() => page.props.direction);

    const alternateLocales = computed(() =>
        page.props.locales
            .filter((other) => other !== locale.value)
            .map((other) => ({
                locale: other,
                href: localizedUrl(other, page.url),
            })),
    );

    return { locale, direction, alternateLocales };
}
