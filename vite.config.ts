import inertia from '@inertiajs/vite';
import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig, lazyPlugins } from 'vite-plus';

export default defineConfig({
    plugins: lazyPlugins(() => [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
            // ESS fonts (Pnud-demo tokens). Downloaded at build time and served from
            // public/build: no visitor request goes to a foreign service (SRS 5.5).
            fonts: [
                bunny('Poppins', {
                    weights: [400, 500, 600, 700],
                    subsets: ['latin', 'latin-ext'],
                }),
                bunny('IBM Plex Sans Arabic', {
                    weights: [400, 500, 600, 700],
                    subsets: ['arabic'],
                }),
            ],
        }),
        inertia(),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ]),
    server: {
        // Lets the app container reach the dev server as http://vite:5173 for SSR
        // (INERTIA_SSR_HOT_URL in compose.yaml).
        allowedHosts: ['vite'],
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/vendor/**',
            ],
        },
    },
    lint: {
        ignorePatterns: [
            'vendor/**',
            'node_modules/**',
            'public/**',
            'bootstrap/ssr/**',
            'tailwind.config.js',
            'resources/js/actions/**',
            'resources/js/components/ui/*',
            'resources/js/routes/**',
            'resources/js/wayfinder/**',
        ],
        options: {
            denyWarnings: true,
            typeAware: true,
        },
        rules: {
            // No `any`, written or leaked in from untyped values
            'typescript/no-explicit-any': 'error',
            'typescript/no-unsafe-argument': 'error',
            'typescript/no-unsafe-assignment': 'error',
            'typescript/no-unsafe-call': 'error',
            'typescript/no-unsafe-member-access': 'error',
            'typescript/no-unsafe-return': 'error',
            // No unused variables, imports, parameters or caught errors
            // (prefix with `_` to mark something as intentionally unused)
            'no-unused-vars': [
                'error',
                {
                    args: 'after-used',
                    argsIgnorePattern: '^_',
                    varsIgnorePattern: '^_',
                    caughtErrors: 'all',
                    caughtErrorsIgnorePattern: '^_',
                    destructuredArrayIgnorePattern: '^_',
                },
            ],
        },
    },
    fmt: {
        printWidth: 80,
        tabWidth: 4,
        singleQuote: true,
        semi: true,
        singleAttributePerLine: false,
        htmlWhitespaceSensitivity: 'css',
        ignorePatterns: [
            // Third-party AI skills/guidelines (managed by `boost:add-skill` / `boost:update`)
            '.ai/**',
            '.github/**',
            // Project documentation, kept exactly as written
            'ERD.html',
            'SRS.md',
            'composer.json',
            'resources/js/components/ui/*',
            'resources/views/mail/*',
        ],
        sortTailwindcss: {
            functions: ['clsx', 'cn', 'cva'],
            stylesheet: 'resources/css/app.css',
        },
    },
});
