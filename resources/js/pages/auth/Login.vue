<script setup lang="ts">
// « Connexion » tab of the demo's connexion page (FR-02): the password step.
import { Form, Head } from '@inertiajs/vue3';
import { User } from '@lucide/vue';
import { useI18n } from 'vue-i18n';
import AuthCard from '@/components/auth/AuthCard.vue';
import PasskeyVerify from '@/components/auth/PasskeyVerify.vue';
import { Alert, AlertDescription } from '@/components/basic/alert';
import { Button } from '@/components/basic/button';
import { Checkbox } from '@/components/basic/checkbox';
import { Input } from '@/components/basic/input';
import { Label } from '@/components/basic/label';
import { Spinner } from '@/components/basic/spinner';
import InputError from '@/components/forms/InputError.vue';
import PasswordInput from '@/components/forms/PasswordInput.vue';
import TextLink from '@/components/typography/TextLink.vue';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        breadcrumb: 'auth.login.pageTitle',
        bare: true,
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const { t } = useI18n();
</script>

<template>
    <Head :title="t('auth.login.pageTitle')" />

    <AuthCard tab="login">
        <h1 class="sr-only">{{ t('auth.login.title') }}</h1>

        <Alert v-if="status" tone="success" class="mb-5">
            <AlertDescription>{{ status }}</AlertDescription>
        </Alert>

        <PasskeyVerify />

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="grid gap-4"
        >
            <div class="grid gap-2">
                <Label for="email">{{ t('common.email') }} *</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    v-focus
                    autocomplete="email"
                    :placeholder="t('auth.login.emailPlaceholder')"
                    :aria-invalid="errors.email ? true : undefined"
                />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">{{ t('common.password') }} *</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    :aria-invalid="errors.password ? true : undefined"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2">
                <label
                    for="remember"
                    class="flex items-center gap-3 text-sm text-ess-slate"
                >
                    <Checkbox id="remember" name="remember" />
                    <span>{{ t('auth.login.rememberMe') }}</span>
                </label>
                <TextLink
                    v-if="canResetPassword"
                    :href="request()"
                    class="text-sm"
                >
                    {{ t('auth.login.forgotPassword') }}
                </TextLink>
            </div>

            <Button
                type="submit"
                block
                diamond
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" />
                <User v-else class="size-4" aria-hidden="true" />
                {{ t('auth.login.submit') }}
            </Button>
        </Form>
    </AuthCard>
</template>
