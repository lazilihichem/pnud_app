<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Check } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/basic/tabs';
import Eyebrow from '@/components/typography/Eyebrow.vue';
import { login, register } from '@/routes';

// The demo's connexion card (pages/connexion.html): « Connexion » / « Créer un compte »
// tabs over the form, and the « Rejoignez l'écosystème » panel underneath. Each tab is its
// own URL (/{locale}/login, /{locale}/register): switching tabs visits the other page.
const props = defineProps<{ tab: 'login' | 'register' }>();

const { t } = useI18n();

const asideItems = [
    'auth.aside.item1',
    'auth.aside.item2',
    'auth.aside.item3',
    'auth.aside.item4',
] as const;

const switchTab = (value: string | number): void => {
    if (value !== props.tab) {
        router.visit(value === 'login' ? login() : register());
    }
};
</script>

<template>
    <div
        class="mx-auto max-w-[560px] overflow-hidden rounded-xl border border-ess-line shadow-ess-lg"
    >
        <div class="bg-ess-paper p-6 sm:p-8 lg:p-10">
            <Tabs
                :model-value="props.tab"
                class="gap-0"
                @update:model-value="switchTab"
            >
                <TabsList :aria-label="t('auth.tabs.label')" class="mb-6">
                    <TabsTrigger value="login">{{
                        t('auth.tabs.login')
                    }}</TabsTrigger>
                    <TabsTrigger value="register">{{
                        t('auth.tabs.register')
                    }}</TabsTrigger>
                </TabsList>
                <TabsContent :value="props.tab">
                    <slot />
                </TabsContent>
            </Tabs>
        </div>
        <aside class="border-t border-ess-line bg-tag-blue p-6">
            <Eyebrow>{{ t('auth.aside.eyebrow') }}</Eyebrow>
            <h2
                class="mt-3 text-xl leading-[1.1] font-bold tracking-[-0.01em] text-ess-ink md:text-[1.375rem] rtl:tracking-normal"
            >
                {{ t('auth.aside.title') }}
            </h2>
            <p class="text-ess-ink">{{ t('auth.aside.text') }}</p>
            <ul class="mt-4 grid gap-2">
                <li
                    v-for="item in asideItems"
                    :key="item"
                    class="flex items-start gap-3 text-sm text-ess-ink"
                >
                    <Check
                        class="mt-0.5 size-4 flex-none text-ess-green-700"
                        aria-hidden="true"
                    />
                    {{ t(item) }}
                </li>
            </ul>
        </aside>
    </div>
</template>
