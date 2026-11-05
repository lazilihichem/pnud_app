<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Alert as UiAlert } from '@/components/ui/alert';
import { cn } from '@/lib/utils';

const props = withDefaults(
    defineProps<{
        tone?: 'info' | 'success' | 'warning' | 'danger' | 'neutral';
        class?: HTMLAttributes['class'];
    }>(),
    { tone: 'info' },
);

const tones = {
    info: 'bg-tag-blue [&>svg]:text-tag-blue-fg',
    success: 'bg-tag-green [&>svg]:text-tag-green-fg',
    warning: 'bg-tag-orange [&>svg]:text-tag-orange-fg',
    danger: 'bg-tag-wine [&>svg]:text-tag-wine-fg',
    neutral: 'bg-tag-neutral [&>svg]:text-tag-neutral-fg',
} as const;
</script>

<template>
    <UiAlert
        :class="
            cn(
                'rounded-lg border-0 px-4 py-3 text-sm text-ess-ink *:data-[slot=alert-description]:text-ess-ink',
                tones[props.tone],
                props.class,
            )
        "
    >
        <slot />
    </UiAlert>
</template>
