<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import PlaceholderPattern from '@/components/dashboard/PlaceholderPattern.vue';
import { dashboard } from '@/routes/platform';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'nav.dashboard',
                href: dashboard(),
            },
        ],
    },
});

const { t } = useI18n();
</script>

<template>
    <Head :title="t('nav.dashboard')" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70"
            >
                <PlaceholderPattern />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min"
        >
            <PlaceholderPattern />
        </div>
    </div>
</template>
