<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Checkbox as UiCheckbox } from '@/components/ui/checkbox';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiCheckbox
        :class="
            cn(
                'size-[18px] rounded-sm border-ess-line-strong bg-ess-paper data-[state=checked]:border-ess-blue data-[state=checked]:bg-ess-blue data-[state=checked]:text-white',
                props.class,
            )
        "
    />
</template>
