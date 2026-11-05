import type { TranslationKey } from '@/i18n';

/**
 * Public portal navigation (SRS FR-06, Pnud-demo js/layout.js « Annexe A »).
 *
 * Paths are relative to /{locale}. Their pages are built with their own modules
 * (Module 2 onwards), so most links answer 404 until then.
 */
export type PublicLink = {
    label: TranslationKey;
    path: string;
};

export const mainNavigation: PublicLink[] = [
    { label: 'public.nav.decouvrir', path: 'decouvrir' },
    { label: 'public.nav.projets', path: 'projets' },
    { label: 'public.nav.accompagnement', path: 'accompagnement' },
    { label: 'public.nav.academie', path: 'academie' },
    { label: 'public.nav.participation', path: 'participation' },
    { label: 'public.nav.ressources', path: 'ressources' },
    { label: 'public.nav.medias', path: 'medias' },
];

export const contactLink: PublicLink = {
    label: 'public.nav.contact',
    path: 'contact',
};

export const searchLink: PublicLink = {
    label: 'public.header.search',
    path: 'recherche',
};

export type FooterGroup = {
    title?: PublicLink;
    links: PublicLink[];
};

/** Footer site map: one array per column (Pnud-demo FOOTER_COLS). */
export const footerColumns: FooterGroup[][] = [
    [
        {
            title: { label: 'public.footer.portal', path: 'decouvrir' },
            links: [
                { label: 'public.nav.decouvrir', path: 'decouvrir' },
                { label: 'public.footer.projects', path: 'projets' },
                { label: 'public.nav.accompagnement', path: 'accompagnement' },
                { label: 'public.footer.academy', path: 'academie' },
                { label: 'public.footer.participation', path: 'participation' },
            ],
        },
    ],
    [
        {
            title: { label: 'public.footer.resources', path: 'ressources' },
            links: [
                { label: 'public.footer.resourceCentre', path: 'ressources' },
                { label: 'public.footer.media', path: 'medias' },
                {
                    label: 'public.footer.agenda',
                    path: 'medias?type=evenements',
                },
            ],
        },
        {
            title: {
                label: 'public.footer.about',
                path: 'decouvrir#programme',
            },
            links: [
                {
                    label: 'public.footer.programme',
                    path: 'decouvrir#programme',
                },
                {
                    label: 'public.footer.partners',
                    path: 'decouvrir#partenaires',
                },
                { label: 'public.footer.faq', path: 'contact#faq' },
            ],
        },
    ],
    [
        {
            links: [
                contactLink,
                { label: 'public.footer.sitemap', path: 'plan-du-site' },
                { label: 'public.footer.legal', path: 'mentions-legales' },
                { label: 'public.footer.privacy', path: 'confidentialite' },
                { label: 'public.footer.accessibility', path: 'accessibilite' },
            ],
        },
    ],
];

/** The terms of use and privacy policy pages, linked from registration (FR-01). */
export const termsLink: PublicLink = {
    label: 'auth.register.termsLink',
    path: 'conditions-utilisation',
};

export const privacyLink: PublicLink = {
    label: 'auth.register.privacyLink',
    path: 'confidentialite',
};

/** The URL of a public page in the given locale. */
export function publicUrl(locale: string, link: PublicLink): string {
    return `/${locale}/${link.path}`;
}
