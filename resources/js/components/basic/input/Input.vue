<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { Input as UiInput } from '@/components/ui/input';
import { cn } from '@/lib/utils';

// v-model, name, type… fall through to the shadcn-vue input.
const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiInput
        :class="
            cn(
                'h-control rounded-lg border-ess-line-strong bg-ess-paper px-3.5 text-base text-ess-ink shadow-ess-xs placeholder:text-ess-slate hover:border-ess-slate-300 md:text-base',
                'focus-visible:border-ess-sky focus-visible:ring-[3px] focus-visible:ring-ess-sky/20',
                'aria-invalid:border-ess-wine aria-invalid:bg-tag-wine aria-invalid:ring-ess-wine/15',
                'disabled:border-ess-line disabled:bg-ess-mist disabled:text-ess-slate-300',
                'file:me-3 file:h-full file:text-sm file:font-semibold file:text-ess-blue',
                props.class,
            )
        "
    />
</template>
