<script setup lang="ts">
import { Languages } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import { useLocale } from '@/composables/useLocale';

const { t } = useI18n();

// Plain links (full page loads): route URLs and layout props are built for one locale.
const { alternateLocales } = useLocale();
</script>

<template>
    <nav
        :aria-label="t('language.label')"
        class="flex items-center gap-2 text-sm text-muted-foreground"
    >
        <Languages class="size-4" />
        <a
            v-for="item in alternateLocales"
            :key="item.locale"
            :href="item.href"
            :lang="item.locale"
            :hreflang="item.locale"
            class="underline-offset-4 hover:text-foreground hover:underline"
        >
            {{ t(`language.${item.locale}`) }}
        </a>
    </nav>
</template>
