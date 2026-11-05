<script setup lang="ts">
import { Eye, EyeOff } from '@lucide/vue';
import { ref, useTemplateRef } from 'vue';
import type { HTMLAttributes } from 'vue';
import { useI18n } from 'vue-i18n';
import { Input } from '@/components/basic/input';
import { cn } from '@/lib/utils';

defineOptions({ inheritAttrs: false });

/**
 * Password field with an optional show/hide control, as the demo draws it per screen:
 * - `icon` (default): the eye button (demo .pwd, new-password screens);
 * - `text`: the « Afficher » / « Masquer » word (demo connexion, « Créer un compte »);
 * - `none`: a plain field (demo sign-in and password confirmation).
 */
const props = withDefaults(
    defineProps<{
        class?: HTMLAttributes['class'];
        autofocus?: boolean;
        toggle?: 'icon' | 'text' | 'none';
    }>(),
    { toggle: 'icon' },
);

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
            :class="
                cn(
                    {
                        'pe-12': props.toggle === 'icon',
                        'pe-24': props.toggle === 'text',
                    },
                    props.class,
                )
            "
            v-bind="$attrs"
        />
        <button
            v-if="props.toggle === 'icon'"
            type="button"
            @click="showPassword = !showPassword"
            class="absolute inset-y-0 end-1 my-auto flex size-10 items-center justify-center rounded-md text-ess-slate hover:bg-ess-mist hover:text-ess-blue focus-visible:ring-[3px] focus-visible:ring-ess-sky/30 focus-visible:outline-none"
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
        <button
            v-else-if="props.toggle === 'text'"
            type="button"
            @click="showPassword = !showPassword"
            class="absolute inset-y-0 end-1.5 my-auto h-fit rounded-sm px-3 py-1.5 text-xs leading-none font-bold text-ess-blue hover:bg-ess-mist focus-visible:ring-[3px] focus-visible:ring-ess-sky/30 focus-visible:outline-none"
            :aria-pressed="showPassword"
            :aria-label="
                showPassword
                    ? t('common.hidePassword')
                    : t('common.showPassword')
            "
        >
            {{ showPassword ? t('common.hide') : t('common.show') }}
        </button>
    </div>
</template>
