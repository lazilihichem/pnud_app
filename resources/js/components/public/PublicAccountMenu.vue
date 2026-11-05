<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronDown } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/basic/dropdown-menu';
import { logout } from '@/routes';
import { dashboard } from '@/routes/platform';
import { edit as editProfile } from '@/routes/platform/profile';

// Signed-in account button of the public header (FR-04): initials + name.
const props = defineProps<{ name: string }>();

const { t } = useI18n();

const initials = computed(() =>
    props.name
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase())
        .join(''),
);
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger
            class="inline-flex items-center gap-2 rounded-full border border-ess-line bg-ess-paper py-1 ps-1 pe-3 text-sm text-ess-ink hover:border-ess-blue"
            :aria-label="t('public.header.account')"
        >
            <span
                class="grid size-8 place-items-center rounded-full bg-ess-blue text-xs font-bold text-white"
                aria-hidden="true"
                >{{ initials }}</span
            >
            <span class="max-w-44 truncate">{{ props.name }}</span>
            <ChevronDown class="size-3.5" aria-hidden="true" />
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="min-w-56">
            <DropdownMenuItem as-child>
                <Link :href="dashboard()">{{
                    t('public.header.mySpace')
                }}</Link>
            </DropdownMenuItem>
            <DropdownMenuItem as-child>
                <Link :href="editProfile()">{{
                    t('public.header.myProfile')
                }}</Link>
            </DropdownMenuItem>
            <DropdownMenuItem as-child>
                <Link :href="logout()" as="button" class="w-full">{{
                    t('public.header.logOut')
                }}</Link>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
