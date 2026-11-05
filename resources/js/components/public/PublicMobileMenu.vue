<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { LogIn, Menu, UserPlus } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import { Button } from '@/components/basic/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetTitle,
    SheetTrigger,
} from '@/components/basic/sheet';
import LanguageToggle from '@/components/public/LanguageToggle.vue';
import {
    contactLink,
    mainNavigation,
    publicUrl,
} from '@/components/public/navigation';
import { useLocale } from '@/composables/useLocale';
import { login, logout, register } from '@/routes';
import { dashboard } from '@/routes/platform';
import { edit as editProfile } from '@/routes/platform/profile';

// Full-screen menu at 1180 px and below (FR-06 step 4).
defineProps<{ signedIn: boolean }>();

const { t } = useI18n();
const { locale, direction } = useLocale();
</script>

<template>
    <Sheet>
        <SheetTrigger as-child>
            <Button
                variant="outline"
                size="icon"
                class="rounded-full text-ess-ink"
                :aria-label="t('public.header.openMenu')"
            >
                <Menu class="size-5" />
            </Button>
        </SheetTrigger>
        <SheetContent
            :side="direction === 'rtl' ? 'left' : 'right'"
            class="w-full max-w-none overflow-y-auto p-6 sm:max-w-sm"
        >
            <SheetTitle>{{ t('public.header.menu') }}</SheetTitle>
            <SheetDescription class="sr-only">{{
                t('public.nav.mobile')
            }}</SheetDescription>
            <nav
                :aria-label="t('public.nav.mobile')"
                class="mt-4 flex flex-col"
            >
                <a
                    v-for="item in [...mainNavigation, contactLink]"
                    :key="item.path"
                    :href="publicUrl(locale, item)"
                    class="border-b border-ess-line py-3 font-medium text-ess-ink hover:text-ess-blue"
                    >{{ t(item.label) }}</a
                >
            </nav>
            <LanguageToggle wide class="mt-6" />
            <div class="mt-6 grid gap-3">
                <template v-if="signedIn">
                    <Button as-child block>
                        <Link :href="dashboard()">{{
                            t('public.header.mySpace')
                        }}</Link>
                    </Button>
                    <Button as-child block variant="outline">
                        <Link :href="editProfile()">{{
                            t('public.header.myProfile')
                        }}</Link>
                    </Button>
                    <Button as-child block variant="outline">
                        <Link :href="logout()" as="button">{{
                            t('public.header.logOut')
                        }}</Link>
                    </Button>
                </template>
                <template v-else>
                    <Button as-child block>
                        <Link :href="login()"
                            ><LogIn class="size-4" />
                            {{ t('public.header.signIn') }}</Link
                        >
                    </Button>
                    <Button as-child block variant="outline">
                        <Link :href="register()"
                            ><UserPlus class="size-4" />
                            {{ t('public.header.createAccount') }}</Link
                        >
                    </Button>
                </template>
            </div>
        </SheetContent>
    </Sheet>
</template>
