import type { Directive } from 'vue';
import type { Auth } from '@/types/auth';
import type { FlashToast } from '@/types/ui';

// Vite declares ImportMetaEnv globally, so it has to be extended globally too
declare global {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        flashDataType: {
            toast?: FlashToast;
        };
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            [key: string]: unknown;
        };
    }
}

declare module 'vue' {
    interface GlobalDirectives {
        vFocus: Directive<HTMLElement, boolean | undefined>;
    }

    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
}
