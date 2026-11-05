<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

// Uppercase over-title preceded by the green diamond (Pnud-demo .eyebrow).
const props = defineProps<{ class?: HTMLAttributes['class'] }>();
</script>

<template>
    <span
        :class="
            cn(
                'inline-flex items-center gap-2 text-xs font-bold tracking-[0.14em] text-ess-blue uppercase rtl:tracking-normal',
                props.class,
            )
        "
    >
        <span
            aria-hidden="true"
            class="size-2.5 flex-none rotate-45 bg-ess-green"
        />
        <slot />
    </span>
</template>
