<script setup lang="ts">
import type { PrimitiveProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { Button as UiButton } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import type { ButtonVariants } from '.';
import { buttonVariants } from '.';

const props = withDefaults(
    defineProps<
        PrimitiveProps & {
            variant?: ButtonVariants['variant'];
            size?: ButtonVariants['size'];
            block?: boolean;
            /** The brand's diamond signature (a CSS pseudo-element, so it also works with as-child). */
            diamond?: boolean;
            class?: HTMLAttributes['class'];
        }
    >(),
    { as: 'button' },
);
</script>

<template>
    <UiButton
        :as="props.as"
        :as-child="props.asChild"
        :class="
            cn(
                buttonVariants({
                    variant: props.variant,
                    size: props.size,
                    block: props.block,
                }),
                props.diamond &&
                    'after:ms-0.5 after:inline-block after:size-[5px] after:shrink-0 after:rotate-45 after:bg-ess-green',
                props.class,
            )
        "
    >
        <slot />
    </UiButton>
</template>
