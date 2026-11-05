<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { InputOTPGroup as UiInputOTPGroup } from '@/components/ui/input-otp';
import { cn } from '@/lib/utils';

const props = defineProps<{
    class?: HTMLAttributes['class'];
}>();
</script>

<template>
    <UiInputOTPGroup :class="cn('gap-2', props.class)">
        <slot />
    </UiInputOTPGroup>
</template>
