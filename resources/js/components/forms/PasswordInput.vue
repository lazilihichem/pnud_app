<script setup lang="ts">
import { Eye, EyeOff } from '@lucide/vue';
import { ref, useTemplateRef } from 'vue';
import type { HTMLAttributes } from 'vue';
import { useI18n } from 'vue-i18n';
import { Input } from '@/components/basic/input';
import { cn } from '@/lib/utils';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    class?: HTMLAttributes['class'];
    autofocus?: boolean;
}>();

const showPassword = ref(false);
const { t } = useI18n();
const inputRef = useTemplateRef('inputRef');

defineExpose({
    $el: inputRef,
    focus: () => inputRef.value?.$el?.focus(),
});
</script>

<template>
    <div class="relative">
        <Input
            v-focus="props.autofocus"
            ref="inputRef"
            :type="showPassword ? 'text' : 'password'"
            :class="cn('pe-12', props.class)"
            v-bind="$attrs"
        />
        <button
            type="button"
            @click="showPassword = !showPassword"
            :class="
                cn(
                    'absolute inset-y-0 end-1 my-auto flex size-10 items-center justify-center rounded-md text-ess-slate hover:bg-ess-mist hover:text-ess-blue focus-visible:ring-[3px] focus-visible:ring-ess-sky/30 focus-visible:outline-none',
                )
            "
            :aria-label="
                showPassword
                    ? t('common.hidePassword')
                    : t('common.showPassword')
            "
            :tabindex="-1"
        >
            <EyeOff v-if="showPassword" class="size-4" />
            <Eye v-else class="size-4" />
        </button>
    </div>
</template>
