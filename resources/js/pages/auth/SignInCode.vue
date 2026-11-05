<script setup lang="ts">
// Functional stub for « Code de vérification » (FR-02). The design comes from the demo later.
// Every expiry and limit is enforced server-side; the countdown here is only a display.
import { Form, Head } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Check } from '@lucide/vue';
import { Alert, AlertDescription } from '@/components/basic/alert';
import { Button } from '@/components/basic/button';
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from '@/components/basic/input-otp';
import { Spinner } from '@/components/basic/spinner';
import InputError from '@/components/forms/InputError.vue';
import { cancel, resend, verify } from '@/routes/login/code';

const props = defineProps<{
    email: string;
    deliveryPending: boolean;
    resendAvailableIn: number;
}>();

defineOptions({
    layout: {
        title: 'auth.signInCode.title',
        description: 'auth.signInCode.description',
        breadcrumb: 'auth.signInCode.pageTitle',
        icon: 'mail',
    },
});

const { t } = useI18n();

const code = ref('');
const secondsLeft = ref(props.resendAvailableIn);
let timer: ReturnType<typeof setInterval> | undefined;

onMounted(() => {
    timer = setInterval(() => {
        secondsLeft.value = Math.max(0, secondsLeft.value - 1);
    }, 1000);
});

onBeforeUnmount(() => clearInterval(timer));

const formatSeconds = (seconds: number): string =>
    `${String(Math.floor(seconds / 60)).padStart(2, '0')}:${String(seconds % 60).padStart(2, '0')}`;
</script>

<template>
    <Head :title="t('auth.signInCode.pageTitle')" />

    <div class="grid gap-5">
        <i18n-t keypath="auth.signInCode.sentTo" tag="p" class="text-ess-slate">
            <template #email>
                <strong class="font-semibold text-ess-ink">{{ email }}</strong>
            </template>
        </i18n-t>

        <Alert v-if="deliveryPending" tone="warning">
            <AlertDescription>{{
                t('auth.signInCode.deliveryPending')
            }}</AlertDescription>
        </Alert>

        <Form
            v-bind="verify.form()"
            class="grid gap-4"
            reset-on-error
            @error="code = ''"
            #default="{ errors, processing }"
        >
            <input type="hidden" name="code" :value="code" />
            <div class="flex flex-col items-center gap-3">
                <InputOTP
                    id="code"
                    v-model="code"
                    :maxlength="6"
                    :disabled="processing"
                    autocomplete="one-time-code"
                    inputmode="numeric"
                    autofocus
                    dir="ltr"
                >
                    <InputOTPGroup>
                        <InputOTPSlot
                            v-for="index in 6"
                            :key="index"
                            :index="index - 1"
                            :aria-invalid="errors.code ? true : undefined"
                        />
                    </InputOTPGroup>
                </InputOTP>
                <InputError :message="errors.code" />
            </div>
            <Button
                type="submit"
                block
                diamond
                :disabled="processing || code.length !== 6"
            >
                <Spinner v-if="processing" />
                <Check v-else class="size-4" aria-hidden="true" />
                {{ t('auth.signInCode.submit') }}
            </Button>
        </Form>

        <div
            class="flex flex-wrap items-start justify-center gap-x-6 gap-y-2 text-sm"
        >
            <Form
                v-bind="resend.form()"
                #default="{ errors, processing }"
                class="flex flex-col items-center"
            >
                <button
                    type="submit"
                    class="font-medium text-ess-blue hover:underline disabled:cursor-default disabled:text-ess-slate disabled:no-underline"
                    :disabled="processing || secondsLeft > 0"
                >
                    <template v-if="secondsLeft > 0">
                        {{
                            t('auth.signInCode.resendIn', {
                                time: formatSeconds(secondsLeft),
                            })
                        }}
                    </template>
                    <template v-else>{{
                        t('auth.signInCode.resend')
                    }}</template>
                </button>
                <InputError :message="errors.code" />
            </Form>

            <Form v-bind="cancel.form()">
                <button
                    type="submit"
                    class="font-medium text-ess-blue hover:underline"
                >
                    {{ t('auth.signInCode.otherAccount') }}
                </button>
            </Form>
        </div>
    </div>
</template>
