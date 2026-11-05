<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { useLocale } from '@/composables/useLocale';
import type { Locale } from '@/i18n';
import { cn } from '@/lib/utils';

// « FR / ع » pill (FR-06). Plain links: each locale is a full page load.
const props = defineProps<{ wide?: boolean }>();

const { t } = useI18n();
const { locale, alternateLocales } = useLocale();

const shortLabels: Record<Locale, string> = { fr: 'FR', ar: 'ع' };

const hrefFor = (target: Locale): string | undefined =>
    alternateLocales.value.find((item) => item.locale === target)?.href;
</script>

<template>
    <div
        role="group"
        :aria-label="t('language.label')"
        :class="
            cn(
                'inline-flex overflow-hidden rounded-full border border-ess-line',
                props.wide && 'flex w-full gap-2 overflow-visible border-0',
            )
        "
    >
        <template v-for="option in ['fr', 'ar'] as const" :key="option">
            <span
                v-if="option === locale"
                :lang="option"
                aria-current="true"
                :class="
                    cn(
                        'bg-ess-blue px-3 py-1.5 text-xs font-bold text-white',
                        props.wide &&
                            'flex-1 rounded-full py-2.5 text-center text-sm',
                    )
                "
            >
                {{ props.wide ? t(`language.${option}`) : shortLabels[option] }}
            </span>
            <a
                v-else
                :href="hrefFor(option)"
                :lang="option"
                :hreflang="option"
                :title="t(`language.${option}`)"
                :class="
                    cn(
                        'px-3 py-1.5 text-xs font-bold text-ess-slate hover:bg-ess-mist hover:text-ess-blue',
                        props.wide &&
                            'flex-1 rounded-full border border-ess-line py-2.5 text-center text-sm',
                    )
                "
            >
                {{ props.wide ? t(`language.${option}`) : shortLabels[option] }}
            </a>
        </template>
    </div>
</template>
