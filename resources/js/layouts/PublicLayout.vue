<script setup lang="ts">
import PublicFooter from '@/components/public/PublicFooter.vue';
import PublicHeader from '@/components/public/PublicHeader.vue';
import PublicPageHero from '@/components/public/PublicPageHero.vue';

// Public portal shell (FR-06, FR-08): header, breadcrumb band, page, footer.
defineProps<{ breadcrumb?: string }>();
</script>

<template>
    <div class="ess-public flex min-h-svh flex-col bg-ess-paper text-ess-ink">
        <a
            href="#main"
            class="sr-only focus:not-sr-only focus:absolute focus:start-4 focus:top-4 focus:z-[100] focus:rounded-md focus:bg-ess-paper focus:px-4 focus:py-2"
            >{{ $t('public.skipLink') }}</a
        >
        <PublicHeader />
        <main id="main" class="flex-1">
            <PublicPageHero v-if="breadcrumb" :current="breadcrumb" />
            <slot />
        </main>
        <PublicFooter />
    </div>
</template>
