<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Card as UiCard } from '@/components/ui/card';
import { cn } from '@/lib/utils';

const props = defineProps<{
    floating?: boolean;
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiCard
        :class="
            cn(
                'rounded-xl border-ess-line bg-ess-paper text-ess-ink shadow-none',
                props.floating && 'shadow-ess-lg',
                props.class,
            )
        "
    >
        <slot />
    </UiCard>
</template>
