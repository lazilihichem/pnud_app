<script setup lang="ts">
import { ChevronUp, Mail, MapPin } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import { footerColumns, publicUrl } from '@/components/public/navigation';
import { useLocale } from '@/composables/useLocale';

// Public portal footer (FR-08): site map, identity, partner strip, utility bar.
// Newsletter (FR-09), social links and the accessibility controls (FR-08) come with Module 2.
const { t } = useI18n();
const { locale } = useLocale();

const year = new Date().getFullYear();

const scrollToTop = (): void => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <footer class="bg-ess-blue-900 text-[#c6d8e8]">
        <div
            class="mx-auto grid max-w-[1200px] gap-x-12 gap-y-8 px-5 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-10"
            :aria-label="t('public.footer.sitemapLabel')"
        >
            <div v-for="(column, index) in footerColumns" :key="index">
                <ul
                    v-for="(group, groupIndex) in column"
                    :key="groupIndex"
                    class="[&+&]:mt-8"
                >
                    <li v-if="group.title">
                        <a
                            :href="publicUrl(locale, group.title)"
                            class="mb-2 inline-block text-sm leading-[2.15] text-[#9be870] hover:text-white"
                            >{{ t(group.title.label) }}</a
                        >
                    </li>
                    <li v-for="link in group.links" :key="link.path">
                        <a
                            :href="publicUrl(locale, link)"
                            class="inline-block border-b border-transparent text-sm leading-[2.15] hover:border-white hover:text-white"
                            >{{ t(link.label) }}</a
                        >
                    </li>
                </ul>
            </div>
            <!-- Phones: identity first, before the site map (demo mobile footer). -->
            <div class="order-first text-sm text-[#93b0c8] md:order-none">
                <div class="mb-4 inline-flex rounded-md bg-white p-4">
                    <img
                        src="/images/logo-ess.jpg"
                        :alt="t('public.header.logoAlt')"
                        class="h-14 w-auto"
                    />
                </div>
                <address class="grid gap-2 not-italic">
                    <span class="flex items-start gap-2"
                        ><MapPin
                            class="mt-0.5 size-4 flex-none text-[#9be870]"
                            aria-hidden="true"
                        />{{ t('public.footer.address') }}</span
                    >
                    <a
                        href="mailto:contact@ess-algerie.dz"
                        class="flex items-center gap-2 hover:text-white"
                        ><Mail
                            class="size-4 flex-none text-[#9be870]"
                            aria-hidden="true"
                        />contact@ess-algerie.dz</a
                    >
                </address>
                <p class="mt-5 text-xs leading-relaxed">
                    {{ t('public.footer.copyright', { year }) }}
                </p>
            </div>
        </div>

        <div class="bg-white py-5">
            <div
                class="mx-auto flex max-w-[1200px] flex-wrap items-center gap-x-8 gap-y-5 px-5 sm:px-6 md:gap-x-12 lg:px-10"
            >
                <span
                    class="basis-full text-sm font-semibold text-[#12212e] md:basis-auto"
                    >{{ t('public.footer.fundedBy') }}</span
                >
                <img
                    src="/images/partners/union-europeenne.webp"
                    :alt="t('public.footer.euAlt')"
                    class="h-12 w-auto"
                />
                <img
                    src="/images/partners/mtess.jpg"
                    :alt="t('public.footer.mtessAlt')"
                    class="h-[68px] w-auto"
                />
                <img
                    src="/images/partners/pnud.webp"
                    :alt="t('public.footer.undpAlt')"
                    class="h-[70px] w-auto"
                />
            </div>
        </div>

        <div
            class="mx-auto flex max-w-[1200px] items-center justify-end px-5 py-5 sm:px-6 lg:px-10"
        >
            <button
                type="button"
                class="inline-flex items-center gap-2 text-sm hover:text-[#9be870]"
                @click="scrollToTop"
            >
                <ChevronUp class="size-4" aria-hidden="true" />
                {{ t('public.footer.backToTop') }}
            </button>
        </div>
    </footer>
</template>
