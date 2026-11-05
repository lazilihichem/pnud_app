<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { InputOTPSlot as UiInputOTPSlot } from '@/components/ui/input-otp';
import { cn } from '@/lib/utils';

const props = defineProps<{
    index: number;
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiInputOTPSlot
        :index="props.index"
        :class="
            cn(
                'h-14 w-12 rounded-lg border-[1.5px] border-transparent bg-ess-mist text-2xl font-semibold text-ess-ink tabular-nums shadow-none first:rounded-lg first:border-[1.5px] last:rounded-lg max-[420px]:h-12 max-[420px]:w-10 max-[420px]:text-xl',
                'data-[active=true]:border-ess-sky data-[active=true]:bg-ess-paper data-[active=true]:ring-[3px] data-[active=true]:ring-ess-sky/20',
                'aria-invalid:border-ess-wine aria-invalid:bg-tag-wine',
                props.class,
            )
        "
    />
</template>
