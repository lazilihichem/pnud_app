import type { App as VueApp, DefineComponent } from 'vue';
import type { Page } from '@inertiajs/core';
import { createAppI18n, defaultLocale, isLocale } from '@/i18n';
import type { Locale } from '@/i18n';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

// Shared by the browser entry (app.ts) and the SSR entry (ssr.ts).

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pages = import.meta.glob<{ default: DefineComponent }>(
    '../pages/**/*.vue',
);

/**
 * Load a page component by name (e.g. 'auth/Login'); each page is its own chunk.
 */
export async function resolve(name: string): Promise<DefineComponent> {
    const page = pages[`../pages/${name}.vue`];

    if (!page) {
        throw new Error(`Page not found: ${name}`);
    }

    return (await page()).default;
}

export const title = (pageTitle: string): string =>
    pageTitle ? `${pageTitle} - ${appName}` : appName;

export const layout = (name: string) => {
    switch (true) {
        case name === 'Welcome':
            return null;
        case name.startsWith('auth/'):
            return AuthLayout;
        case name.startsWith('settings/'):
            return [AppLayout, SettingsLayout];
        default:
            return AppLayout;
    }
};

export function pageLocale(page: Page): Locale {
    const locale = page.props.locale;

    return isLocale(locale) ? locale : defaultLocale;
}

/**
 * Register the plugins and directives every app instance needs.
 */
export function configureApp(app: VueApp, page: Page): void {
    app.directive('focus', {
        mounted: (el: HTMLElement, shouldFocus) => {
            if (shouldFocus.value !== false) {
                el.focus();
            }
        },
    });

    app.use(createAppI18n(pageLocale(page)));
}
