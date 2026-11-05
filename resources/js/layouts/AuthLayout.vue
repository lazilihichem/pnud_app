<script setup lang="ts">
import { KeyRound, LockKeyhole, Mail, ShieldCheck } from '@lucide/vue';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { Card } from '@/components/basic/card';
import type { TranslationKey } from '@/i18n';
import PublicLayout from '@/layouts/PublicLayout.vue';

/**
 * Authentication pages inside the public portal shell (Pnud-demo pages/*.html).
 *
 * Pages set these through `defineOptions({ layout: { … } })`:
 * - `title` / `description`: translation keys; the title is also the breadcrumb;
 * - `breadcrumb`: a shorter key for the breadcrumb, when the title is a sentence;
 * - `icon`: the round pictogram above a narrow card (`mail`, `key`, `lock`, `shield`);
 * - `bare`: the page draws its own card (the connexion tabs), no narrow card around it.
 */
const props = defineProps<{
    title?: TranslationKey;
    description?: TranslationKey;
    breadcrumb?: TranslationKey;
    icon?: 'mail' | 'key' | 'lock' | 'shield';
    bare?: boolean;
}>();

const { t } = useI18n();

const icons = {
    mail: Mail,
    key: KeyRound,
    lock: LockKeyhole,
    shield: ShieldCheck,
} as const;

const crumb = computed(() => {
    const key = props.breadcrumb ?? props.title;

    return key ? t(key) : '';
});
</script>

<template>
    <PublicLayout :breadcrumb="crumb">
        <div
            :class="[
                'mx-auto max-w-[1200px] px-5 sm:px-6 lg:px-10',
                props.bare ? 'pb-24' : 'pt-10 pb-20',
            ]"
        >
            <slot v-if="props.bare" />
            <Card v-else class="mx-auto max-w-[540px] gap-0 p-6 sm:p-8 lg:p-10">
                <div
                    v-if="props.icon"
                    class="mb-4 grid size-14 place-items-center rounded-full bg-tag-blue text-ess-blue"
                    aria-hidden="true"
                >
                    <component :is="icons[props.icon]" class="size-7" />
                </div>
                <h1
                    v-if="props.title"
                    class="text-[1.75rem] leading-snug font-bold text-ess-ink"
                >
                    {{ t(props.title) }}
                </h1>
                <p v-if="props.description" class="mt-2 text-ess-slate">
                    {{ t(props.description) }}
                </p>
                <div class="mt-6">
                    <slot />
                </div>
            </Card>
        </div>
    </PublicLayout>
</template>
