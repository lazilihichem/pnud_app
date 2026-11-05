<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import InputError from '@/components/forms/InputError.vue';
import PasswordInput from '@/components/forms/PasswordInput.vue';
import { Button } from '@/components/basic/button';
import { Input } from '@/components/basic/input';
import { Label } from '@/components/basic/label';
import { Spinner } from '@/components/basic/spinner';
import { update } from '@/routes/password';

defineOptions({
    layout: {
        title: 'auth.resetPassword.title',
        description: 'auth.resetPassword.description',
        icon: 'lock',
    },
});

const props = defineProps<{
    token: string;
    email: string;
    passwordRules: string;
}>();

const inputEmail = ref(props.email);

const { t } = useI18n();
</script>

<template>
    <Head :title="t('auth.resetPassword.title')" />

    <Form
        v-bind="update.form()"
        :transform="(data) => ({ ...data, token, email })"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="email">{{ t('common.email') }}</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    autocomplete="email"
                    v-model="inputEmail"
                    class="mt-1 block w-full"
                    readonly
                />
                <InputError :message="errors.email" class="mt-2" />
            </div>

            <div class="grid gap-2">
                <Label for="password">{{ t('common.password') }}</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    autofocus
                    :placeholder="t('common.password')"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">{{
                    t('common.confirmPassword')
                }}</Label>
                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    :placeholder="t('common.confirmPassword')"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password_confirmation" />
            </div>

            <Button
                type="submit"
                class="mt-4 w-full"
                :disabled="processing"
                data-test="reset-password-button"
            >
                <Spinner v-if="processing" />
                {{ t('auth.resetPassword.submit') }}
            </Button>
        </div>
    </Form>
</template>
