<script setup lang="ts">
// Placeholder home of a profile: each role module (FR-36, FR-46, back-office…) fills its page.
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Heading from '@/components/typography/Heading.vue';
import type { TranslationKey } from '@/i18n';

const props = defineProps<{
    title: TranslationKey;
    description: TranslationKey;
}>();

const { t } = useI18n();
</script>

<template>
    <Head :title="t(props.title)" />

    <div class="p-6">
        <Heading :title="t(props.title)" :description="t(props.description)" />
        <p class="mt-4 text-sm text-ess-slate">{{ t('home.comingSoon') }}</p>
    </div>
</template>
