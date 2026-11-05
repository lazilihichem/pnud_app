<script setup lang="ts">
import { ChevronDown } from '@lucide/vue';
import type { HTMLAttributes } from 'vue';
import { cn } from '@/lib/utils';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();

// Defaults to '' so the « Choisir… » option (value="") shows when nothing is bound.
const model = defineModel<string | number>({ default: '' });
</script>

<template>
    <div class="relative">
        <select
            v-model="model"
            v-bind="$attrs"
            :class="
                cn(
                    'h-control w-full cursor-pointer appearance-none rounded-lg border border-ess-line-strong bg-ess-paper ps-3.5 pe-10 text-base text-ess-ink shadow-ess-xs transition-[color,box-shadow,border-color] outline-none hover:border-ess-slate-300',
                    'focus-visible:border-ess-sky focus-visible:ring-[3px] focus-visible:ring-ess-sky/20',
                    'aria-invalid:border-ess-wine aria-invalid:bg-tag-wine',
                    'disabled:cursor-not-allowed disabled:bg-ess-mist disabled:text-ess-slate-300',
                    props.class,
                )
            "
        >
            <slot />
        </select>
        <ChevronDown
            aria-hidden="true"
            class="pointer-events-none absolute end-3 top-1/2 size-4 -translate-y-1/2 text-ess-slate"
        />
    </div>
</template>
