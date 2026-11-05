<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
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
defineProps<{ current: string }>();

const { t } = useI18n();
</script>

<template>
    <section class="border-b border-ess-line bg-ess-mist">
        <div class="mx-auto max-w-[1200px] px-4 py-3 sm:px-6 lg:px-10">
            <Breadcrumb :aria-label="t('public.breadcrumb.label')">
                <BreadcrumbList class="text-sm text-ess-slate">
                    <BreadcrumbItem>
                        <BreadcrumbLink as-child class="hover:text-ess-blue">
                            <Link :href="home()">{{
                                t('public.breadcrumb.home')
                            }}</Link>
                        </BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator class="text-ess-line-strong"
                        >/</BreadcrumbSeparator
                    >
                    <BreadcrumbItem>
                        <BreadcrumbPage class="font-semibold text-ess-ink">{{
                            current
                        }}</BreadcrumbPage>
                    </BreadcrumbItem>
                </BreadcrumbList>
            </Breadcrumb>
        </div>
    </section>
</template>
