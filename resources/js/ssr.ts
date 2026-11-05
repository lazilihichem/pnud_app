/// <reference types="node" />

// i18n must load first: it sets Wayfinder's {locale} URL default before any page module runs.
import { defaultLocale, directionFor, setActiveLocaleResolver } from '@/i18n';
import type { Locale } from '@/i18n';
import { App as InertiaApp, createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { AsyncLocalStorage } from 'node:async_hooks';
import { ConfigProvider } from 'reka-ui';
import { createSSRApp, h } from 'vue';
import type { Plugin } from 'vue';
import { renderToString } from 'vue/server-renderer';
import {
    configureApp,
    layout,
    pageLocale,
    resolve,
    title,
} from '@/lib/inertiaApp';

// One SSR process renders many requests concurrently, so the locale used for
// route URLs is scoped to each render instead of being shared module state.
const renderLocale = new AsyncLocalStorage<Locale>();

// Annotated so TypeScript picks the SSR overload of createInertiaApp (el is null).
type SsrSetupOptions = {
    el: null;
    App: typeof InertiaApp;
    props: InstanceType<typeof InertiaApp>['$props'];
    plugin: Plugin;
};

setActiveLocaleResolver(() => renderLocale.getStore() ?? defaultLocale);

createServer((page) => {
    const locale = pageLocale(page);

    return renderLocale.run(locale, () =>
        createInertiaApp({
            page,
            render: renderToString,
            resolve,
            title,
            layout,
            setup({ App, props, plugin }: SsrSetupOptions) {
                const app = createSSRApp({
                    render: () =>
                        h(ConfigProvider, { dir: directionFor(locale) }, () =>
                            h(App, props),
                        ),
                });

                configureApp(app, page);
                app.use(plugin);

                return app;
            },
        }),
    );
});
