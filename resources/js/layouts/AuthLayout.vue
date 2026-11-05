<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import type { TranslationKey } from '@/i18n';
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

const { title, description } = defineProps<{
    title?: TranslationKey;
    description?: TranslationKey;
}>();

const { t } = useI18n();
</script>

<template>
    <AuthLayout
        :title="title ? t(title) : ''"
        :description="description ? t(description) : ''"
    >
        <slot />
    </AuthLayout>
</template>
