<script setup lang="ts">
import type { TabsTriggerProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { TabsTrigger as UiTabsTrigger } from '@/components/ui/tabs';
import { cn } from '@/lib/utils';

const props = defineProps<
    TabsTriggerProps & { class?: HTMLAttributes['class'] }
>();
</script>

<template>
    <UiTabsTrigger
        :value="props.value"
        :disabled="props.disabled"
        :class="
            cn(
                '-mb-px h-auto flex-none rounded-none border-0 border-b-[3px] border-transparent bg-transparent px-4 py-3 text-base font-semibold text-ess-slate shadow-none hover:text-ess-ink',
                'data-[state=active]:border-ess-blue data-[state=active]:bg-transparent data-[state=active]:text-ess-blue data-[state=active]:shadow-none',
                'dark:data-[state=active]:border-ess-blue dark:data-[state=active]:bg-transparent dark:data-[state=active]:text-ess-blue',
                props.class,
            )
        "
    >
        <slot />
    </UiTabsTrigger>
</template>
