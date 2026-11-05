import type { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from '@lucide/vue';
import type { TranslationKey } from '@/i18n';

export type BreadcrumbItem = {
    /** Translation key, translated where the breadcrumb is rendered. */
    title: TranslationKey;
    href: NonNullable<InertiaLinkProps['href']>;
};

export type NavItem = {
    /** Translation key, translated where the item is rendered. */
    title: TranslationKey;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
};
