<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { Languages, LogOut, Settings } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import UserInfo from '@/components/UserInfo.vue';
import { currentLocale, locales, localizedUrl } from '@/i18n';
import { logout } from '@/routes';
import { edit } from '@/routes/profile';
import type { User } from '@/types';

type Props = {
    user: User;
};

const handleLogout = () => {
    router.flushAll();
};

defineProps<Props>();

const { t } = useI18n();
const page = usePage();

// Plain links (full page loads): route URLs and layout props are built for one locale.
const otherLocales = computed(() =>
    locales
        .filter((locale) => locale !== currentLocale)
        .map((locale) => ({ locale, href: localizedUrl(locale, page.url) })),
);
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
            <UserInfo :user="user" :show-email="true" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem :as-child="true">
            <Link class="block w-full cursor-pointer" :href="edit()" prefetch>
                <Settings class="me-2 h-4 w-4" />
                {{ t('nav.settings') }}
            </Link>
        </DropdownMenuItem>
        <DropdownMenuItem
            v-for="item in otherLocales"
            :key="item.locale"
            :as-child="true"
        >
            <a
                class="block w-full cursor-pointer"
                :href="item.href"
                :lang="item.locale"
                :hreflang="item.locale"
            >
                <Languages class="me-2 h-4 w-4" />
                {{ t(`language.${item.locale}`) }}
            </a>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link
            class="block w-full cursor-pointer"
            :href="logout()"
            @click="handleLogout"
            as="button"
            data-test="logout-button"
        >
            <LogOut class="me-2 h-4 w-4" />
            {{ t('common.logOut') }}
        </Link>
    </DropdownMenuItem>
</template>
