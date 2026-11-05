// ESS basic button over the shadcn-vue `button` primitive (reka-ui).
// Variants follow Pnud-demo css/components.css (.btn--*) and DESIGN.md:
// one primary per context; destructive actions are outlined, solid only to confirm a refusal.
import type { VariantProps } from 'class-variance-authority';
import { cva } from 'class-variance-authority';

export { default as Button } from './Button.vue';

export const buttonVariants = cva(
    'h-control gap-2 rounded-button border border-transparent px-5 text-sm font-semibold tracking-[0.012em] shadow-none transition-colors active:shadow-[inset_0_1px_3px_rgb(18_33_46/0.28)] rtl:tracking-normal',
    {
        variants: {
            variant: {
                default:
                    'bg-ess-blue text-white hover:bg-ess-blue-700 hover:shadow-[inset_0_0_0_1px_rgb(255_255_255/0.24)]',
                accent: 'bg-ess-green text-white hover:bg-ess-green-700 hover:shadow-[inset_0_0_0_1px_rgb(255_255_255/0.28)]',
                outline:
                    'border-ess-line-strong bg-transparent text-ess-blue hover:border-ess-blue hover:bg-ess-mist hover:text-ess-blue',
                secondary: 'bg-ess-mist text-ess-ink hover:bg-ess-mist-200',
                ghost: 'bg-transparent px-2.5 text-ess-blue hover:bg-transparent hover:text-ess-sky',
                link: 'h-auto bg-transparent px-0 text-ess-blue underline-offset-4 hover:underline',
                destructive:
                    'border-ess-wine bg-transparent text-ess-wine hover:bg-ess-wine hover:text-white',
                'destructive-solid':
                    'border-ess-wine bg-ess-wine text-white hover:border-ess-wine-700 hover:bg-ess-wine-700',
                'on-blue': 'bg-white text-ess-blue hover:bg-ess-mist',
            },
            size: {
                default: '',
                // Demo .btn--sm (0.55em 1em at 12px): the header « S'inscrire ».
                sm: 'h-[27px] px-3 text-xs',
                lg: 'h-12 px-7 text-base',
                icon: 'size-control px-0',
                'icon-sm': 'size-9 px-0',
                'icon-lg': 'size-12 px-0',
            },
            block: {
                true: 'flex w-full',
                false: '',
            },
        },
        defaultVariants: {
            variant: 'default',
            size: 'default',
            block: false,
        },
    },
);

export type ButtonVariants = VariantProps<typeof buttonVariants>;
