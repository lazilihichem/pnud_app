import type { MessageSchema } from '@/i18n';

// Type-check translation keys passed to t() / $t() against the French master schema.
declare module 'vue-i18n' {
    export interface DefineLocaleMessage extends MessageSchema {}
}
