<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Search } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Button } from '@/components/basic/button';
import LanguageToggle from '@/components/public/LanguageToggle.vue';
import {
    mainNavigation,
    publicUrl,
    searchLink,
} from '@/components/public/navigation';
import PublicAccountMenu from '@/components/public/PublicAccountMenu.vue';
import PublicMobileMenu from '@/components/public/PublicMobileMenu.vue';
import { useLocale } from '@/composables/useLocale';
import { home, login, register } from '@/routes';

// Public portal header (FR-06): logo, main menu, search, FR / ع, account access.
const { t } = useI18n();
const { locale } = useLocale();
const page = usePage();

const user = computed(
    () => (page.props.auth?.user ?? null) as { name: string } | null,
);

const isCurrent = (path: string): boolean =>
    page.url.startsWith(`/${locale.value}/${path}`);
</script>

<template>
    <header
        class="sticky top-0 z-50 border-b border-ess-line bg-ess-paper/90 backdrop-blur-md"
    >
        <div
            class="mx-auto flex min-h-[76px] max-w-[1320px] items-center gap-6 px-4 sm:px-6 lg:px-10"
        >
            <Link
                :href="home()"
                class="flex-none"
                :aria-label="t('public.header.home')"
            >
                <img
                    src="/images/logo-ess.jpg"
                    :alt="t('public.header.logoAlt')"
                    class="h-[46px] w-auto"
                />
            </Link>

            <nav
                :aria-label="t('public.nav.main')"
                class="mx-auto hidden xl:block"
            >
                <ul class="flex items-center gap-1 2xl:gap-2">
                    <li v-for="item in mainNavigation" :key="item.path">
                        <a
                            :href="publicUrl(locale, item)"
                            :aria-current="
                                isCurrent(item.path) ? 'page' : undefined
                            "
                            class="inline-flex rounded-md px-2.5 py-2 text-sm font-medium whitespace-nowrap text-ess-ink hover:bg-ess-mist hover:text-ess-blue aria-[current=page]:font-semibold aria-[current=page]:text-ess-blue 2xl:px-3.5"
                            >{{ t(item.label) }}</a
                        >
                    </li>
                </ul>
            </nav>

            <div class="ms-auto flex flex-none items-center gap-3 xl:ms-0">
                <Button
                    as="a"
                    :href="publicUrl(locale, searchLink)"
                    variant="outline"
                    size="icon"
                    class="hidden size-[42px] rounded-full border-ess-line text-ess-ink xl:inline-flex"
                    :aria-label="t('public.header.search')"
                >
                    <Search class="size-5" />
                </Button>
                <LanguageToggle />
                <template v-if="user">
                    <div class="hidden xl:block">
                        <PublicAccountMenu :name="user.name" />
                    </div>
                </template>
                <template v-else>
                    <Link
                        :href="login()"
                        class="hidden rounded-sm px-2 py-1.5 text-sm font-semibold whitespace-nowrap text-ess-blue hover:bg-ess-mist 2xl:inline"
                        >{{ t('public.header.signIn') }}</Link
                    >
                    <Button
                        as-child
                        size="sm"
                        diamond
                        class="hidden xl:inline-flex"
                    >
                        <Link :href="register()">{{
                            t('public.header.signUp')
                        }}</Link>
                    </Button>
                </template>
                <div class="xl:hidden">
                    <PublicMobileMenu :signed-in="user !== null" />
                </div>
            </div>
        </div>
    </header>
</template>
