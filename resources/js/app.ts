// i18n must load first: it sets Wayfinder's {locale} URL default before any page module runs.
import {
    currentDirection,
    currentLocale,
    i18n,
    isLocale,
    localizedUrl,
} from '@/i18n';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { ConfigProvider } from 'reka-ui';
import { createApp, h } from 'vue';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
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
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () =>
                h(ConfigProvider, { dir: currentDirection }, () =>
                    h(App, props),
                ),
        });

        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });

        app.use(plugin).use(i18n);

        if (el) {
            app.mount(el);
        }
    },
    progress: {
        color: '#4B5563',
    },
});

// The locale is fixed for the lifetime of a page load (route URLs and layout
// props are built from it), so a visit that lands on another locale reloads.
router.on('navigate', (event) => {
    const pageLocale = event.detail.page.props.locale;

    if (isLocale(pageLocale) && pageLocale !== currentLocale) {
        window.location.href = localizedUrl(pageLocale, event.detail.page.url);
    }
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
