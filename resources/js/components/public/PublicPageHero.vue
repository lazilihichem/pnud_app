<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/basic/breadcrumb';
import { home } from '@/routes';

// The mist band under the header carrying the breadcrumb (Pnud-demo .page-hero).
// Phones (demo mobile.css): only the parent stays, as a « ← Accueil » back link with a
// 44px tap height; the current page is hidden but kept in the markup.
defineProps<{ current: string }>();

const { t } = useI18n();
</script>

<template>
    <section class="border-b border-ess-line bg-ess-mist">
        <div class="mx-auto max-w-[1200px] px-5 pb-4 sm:px-6 md:py-2 lg:px-10">
            <Breadcrumb :aria-label="t('public.breadcrumb.label')">
                <BreadcrumbList class="text-sm text-ess-slate">
                    <BreadcrumbItem>
                        <BreadcrumbLink
                            as-child
                            class="inline-flex min-h-11 items-center gap-2 pe-3 text-base font-semibold text-ess-blue hover:text-ess-blue md:min-h-0 md:pe-0 md:text-sm md:font-normal md:text-ess-slate"
                        >
                            <Link :href="home()">
                                <ArrowLeft
                                    class="size-[18px] flex-none md:hidden rtl:rotate-180"
                                    aria-hidden="true"
                                />
                                {{ t('public.breadcrumb.home') }}
                            </Link>
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator
                        class="hidden text-ess-line-strong md:list-item"
                        >/</BreadcrumbSeparator
                    >
                    <BreadcrumbItem class="hidden md:inline-flex">
                        <BreadcrumbPage class="font-semibold text-ess-ink">{{
                            current
                        }}</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>
        </div>
    </section>
</template>
