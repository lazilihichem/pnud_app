// i18n must load first: it sets Wayfinder's {locale} URL default before any page module runs.
import { documentLocale, isLocale, localizedUrl } from '@/i18n';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { ConfigProvider } from 'reka-ui';
import { createApp, createSSRApp, h } from 'vue';
import { initializeTheme } from '@/composables/useAppearance';
import { configureApp, layout, resolve, title } from '@/lib/inertiaApp';
import { initializeFlashToast } from '@/lib/flashToast';

void createInertiaApp({
    resolve,
    title,
    layout,
    setup({ el, App, props, plugin }) {
        const page = props.initialPage;

        // Public pages arrive server-rendered and are hydrated; others are mounted.
        const createVueApp =
            el?.dataset.serverRendered === 'true' ? createSSRApp : createApp;

        const app = createVueApp({
            render: () =>
                h(ConfigProvider, { dir: page.props.direction }, () =>
                    h(App, props),
                ),
        });

        configureApp(app, page);
        app.use(plugin);

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

    if (isLocale(pageLocale) && pageLocale !== documentLocale()) {
        window.location.href = localizedUrl(pageLocale, event.detail.page.url);
    }
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
