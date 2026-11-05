import type { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx } from 'clsx';
import type { ClassValue } from 'clsx';
import { extendTailwindMerge } from 'tailwind-merge';

// Teach tailwind-merge the ESS theme tokens (resources/css/app.css), so that
// `h-control` overrides `h-9`, `rounded-button` overrides `rounded-md`, etc. Without the
// colours, `text-ess-slate` reads as a font size and silently drops `text-sm`.
const twMerge = extendTailwindMerge({
    extend: {
        theme: {
            color: [
                (value: string): boolean =>
                    /^(ess|tag)-[a-z0-9-]+$/.test(value),
            ],
            spacing: ['control', 'chip'],
            radius: ['button'],
            shadow: ['ess-xs', 'ess-sm', 'ess-md', 'ess-lg'],
        },
    },
});

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}
