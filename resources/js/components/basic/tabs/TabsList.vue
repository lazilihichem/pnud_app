<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { TabsList as UiTabsList } from '@/components/ui/tabs';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiTabsList
        :class="
            cn(
                'h-auto w-full justify-start gap-2 rounded-none border-b border-ess-line bg-transparent p-0',
                props.class,
            )
        "
    >
        <slot />
    </UiTabsList>
</template>
