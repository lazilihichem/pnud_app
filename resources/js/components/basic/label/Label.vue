<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Label as UiLabel } from '@/components/ui/label';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiLabel :class="cn('text-sm font-semibold text-ess-ink', props.class)">
        <slot />
    </UiLabel>
</template>
