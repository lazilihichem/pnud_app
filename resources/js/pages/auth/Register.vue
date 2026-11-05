<script setup lang="ts">
// « Créer un compte » tab of the demo's connexion page (FR-01).
import { Form, Head } from '@inertiajs/vue3';
import { Check } from '@lucide/vue';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import AuthCard from '@/components/auth/AuthCard.vue';
import { Button } from '@/components/basic/button';
import { Input } from '@/components/basic/input';
import { Label } from '@/components/basic/label';
import { NativeSelect } from '@/components/basic/native-select';
import { Spinner } from '@/components/basic/spinner';
import InputError from '@/components/forms/InputError.vue';
import PasswordInput from '@/components/forms/PasswordInput.vue';
import TextLink from '@/components/typography/TextLink.vue';
import {
    privacyLink,
    publicUrl,
    termsLink,
} from '@/components/public/navigation';
import { useLocale } from '@/composables/useLocale';
import { login } from '@/routes';
import { request } from '@/routes/password';
import { store } from '@/routes/register';

type Option<T> = { value: T; label: string };

defineProps<{
    roles: Option<string>[];
    wilayas: Option<number>[];
    passwordRules: string;
}>();

defineOptions({
    layout: {
        breadcrumb: 'auth.register.pageTitle',
        bare: true,
    },
});

const { t } = useI18n();
const { locale } = useLocale();

// Switching profile unmounts the fields of the previous one, so they are never submitted.
const role = ref('');

// Bound from script: a literal "https://" in a template attribute breaks vue-tsc's slot scope.
const linkedinPlaceholder = 'https://www.linkedin.com/in/…';
</script>

<template>
    <Head :title="t('auth.register.pageTitle')" />

    <AuthCard tab="register">
        <h1 class="sr-only">{{ t('auth.register.title') }}</h1>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="grid gap-4"
        >
            <div class="grid gap-2">
                <Label for="role"
                    >{{ t('auth.register.role') }} *
                    <span class="text-xs font-normal text-ess-slate"
                        >— {{ t('auth.register.roleHintFirst') }}</span
                    ></Label
                >
                <NativeSelect
                    id="role"
                    v-model="role"
                    name="role"
                    class="h-[60px]"
                    :aria-invalid="errors.role ? true : undefined"
                >
                    <option value="" disabled>
                        {{ t('auth.register.chooseRole') }}
                    </option>
                    <option
                        v-for="option in roles"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </option>
                </NativeSelect>
                <p class="text-xs text-ess-slate">
                    {{ t('auth.register.roleHint') }}
                </p>
                <InputError :message="errors.role" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="grid content-start gap-2">
                    <Label for="name">{{ t('common.fullName') }} *</Label>
                    <Input
                        id="name"
                        name="name"
                        autocomplete="name"
                        maxlength="100"
                        :aria-invalid="errors.name ? true : undefined"
                    />
                    <InputError :message="errors.name" />
                </div>
                <div class="grid content-start gap-2">
                    <Label for="email">{{ t('common.email') }} *</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="email"
                        maxlength="254"
                        :aria-invalid="errors.email ? true : undefined"
                    />
                    <InputError :message="errors.email" />
                    <p v-if="errors.email" class="flex gap-3 text-sm">
                        <TextLink :href="login()">{{
                            t('common.logIn')
                        }}</TextLink>
                        <TextLink :href="request()">{{
                            t('auth.login.forgotPassword')
                        }}</TextLink>
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="grid content-start gap-2">
                    <Label for="organisation">{{
                        t('auth.register.organisation')
                    }}</Label>
                    <Input
                        id="organisation"
                        name="organisation"
                        autocomplete="organization"
                        maxlength="150"
                        :aria-invalid="errors.organisation ? true : undefined"
                    />
                    <InputError :message="errors.organisation" />
                </div>
                <div class="grid content-start gap-2">
                    <Label for="wilaya_id"
                        >{{ t('auth.register.wilaya') }} *</Label
                    >
                    <NativeSelect
                        id="wilaya_id"
                        name="wilaya_id"
                        :aria-invalid="errors.wilaya_id ? true : undefined"
                    >
                        <option value="">
                            {{ t('auth.register.chooseWilaya') }}
                        </option>
                        <option
                            v-for="option in wilayas"
                            :key="option.value"
                            :value="option.value"
                        >
                            {{ option.label }}
                        </option>
                    </NativeSelect>
                    <InputError :message="errors.wilaya_id" />
                </div>
            </div>

            <div v-if="role === 'accompagnateur'" class="grid gap-2">
                <Label for="fonction"
                    >{{ t('auth.register.fonction') }} *</Label
                >
                <Input
                    id="fonction"
                    name="fonction"
                    maxlength="150"
                    :aria-invalid="errors.fonction ? true : undefined"
                />
                <InputError :message="errors.fonction" />
            </div>

            <div v-if="role === 'formateur'" class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="linkedin_url">{{
                        t('auth.register.linkedin')
                    }}</Label>
                    <Input
                        id="linkedin_url"
                        type="url"
                        name="linkedin_url"
                        maxlength="300"
                        :placeholder="linkedinPlaceholder"
                        :aria-invalid="errors.linkedin_url ? true : undefined"
                    />
                    <InputError :message="errors.linkedin_url" />
                </div>
                <div class="grid gap-2">
                    <Label for="education"
                        >{{ t('auth.register.education') }} *</Label
                    >
                    <Input
                        id="education"
                        name="education"
                        maxlength="300"
                        :aria-invalid="errors.education ? true : undefined"
                    />
                    <InputError :message="errors.education" />
                </div>
                <div class="grid gap-2">
                    <Label for="cv">{{ t('auth.register.cv') }} *</Label>
                    <Input
                        id="cv"
                        type="file"
                        name="cv"
                        accept=".pdf,.doc,.docx"
                        class="py-2"
                        :aria-invalid="errors.cv ? true : undefined"
                    />
                    <p class="text-xs text-ess-slate">
                        {{ t('auth.register.cvHint') }}
                    </p>
                    <InputError :message="errors.cv" />
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="password">{{ t('common.password') }} *</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    maxlength="64"
                    aria-describedby="password-hint"
                    :passwordrules="passwordRules"
                    :aria-invalid="errors.password ? true : undefined"
                />
                <p id="password-hint" class="text-xs text-ess-slate">
                    {{ t('auth.register.passwordHint') }}
                </p>
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation"
                    >{{ t('common.confirmPassword') }} *</Label
                >
                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    maxlength="64"
                    :passwordrules="passwordRules"
                />
            </div>

            <div class="grid gap-2">
                <label class="flex items-start gap-3 text-sm text-ess-slate">
                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        class="mt-0.5 size-[18px] flex-none accent-ess-blue"
                    />
                    <i18n-t keypath="auth.register.terms" tag="span">
                        <template #terms>
                            <a
                                :href="publicUrl(locale, termsLink)"
                                target="_blank"
                                rel="noopener"
                                class="text-ess-blue hover:underline"
                                >{{ t(termsLink.label) }}</a
                            >
                        </template>
                        <template #privacy>
                            <a
                                :href="publicUrl(locale, privacyLink)"
                                target="_blank"
                                rel="noopener"
                                class="text-ess-blue hover:underline"
                                >{{ t(privacyLink.label) }}</a
                            >
                        </template>
                    </i18n-t>
                </label>
                <InputError :message="errors.terms" />
            </div>

            <Button
                type="submit"
                variant="accent"
                block
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" />
                <Check v-else class="size-4" aria-hidden="true" />
                {{ t('auth.register.submit') }}
            </Button>
        </Form>
    </AuthCard>
</template>
