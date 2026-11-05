<script setup lang="ts">
// Functional stub for « Code de vérification » (FR-02). The design comes from the demo later.
// Every expiry and limit is enforced server-side; the countdown here is only a display.
import { Form, Head } from '@inertiajs/vue3';
import { onBeforeUnmount, onMounted, ref } from 'vue';
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
        title: 'Vérifiez votre adresse e-mail',
        description:
            'Saisissez le code à 6 chiffres envoyé par e-mail. Il est valable 5 minutes et ne sert qu’une fois.',
    },
});

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
    <Head title="Code de vérification" />

    <div class="space-y-6">
        <p class="text-center text-sm text-muted-foreground">
            Code envoyé à <strong>{{ email }}</strong>
        </p>

        <p
            v-if="deliveryPending"
            class="rounded-md bg-amber-50 p-3 text-center text-sm text-amber-800"
        >
            L’envoi du code prend plus de temps que prévu.
        </p>

        <Form
            v-bind="verify.form()"
            class="space-y-4"
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
                >
                    <InputOTPGroup>
                        <InputOTPSlot
                            v-for="index in 6"
                            :key="index"
                            :index="index - 1"
                        />
                    </InputOTPGroup>
                </InputOTP>
                <InputError :message="errors.code" />
            </div>
            <Button
                type="submit"
                class="w-full"
                :disabled="processing || code.length !== 6"
            >
                <Spinner v-if="processing" />
                Valider
            </Button>
        </Form>

        <div
            class="flex items-center justify-between gap-4 text-sm text-muted-foreground"
        >
            <Form
                v-bind="resend.form()"
                #default="{ errors, processing }"
                class="flex flex-col"
            >
                <button
                    type="submit"
                    class="text-left underline underline-offset-4 disabled:no-underline disabled:opacity-60"
                    :disabled="processing || secondsLeft > 0"
                >
                    <template v-if="secondsLeft > 0">
                        Renvoyer le code dans {{ formatSeconds(secondsLeft) }}
                    </template>
                    <template v-else>Renvoyer le code</template>
                </button>
                <InputError :message="errors.code" />
            </Form>

            <Form v-bind="cancel.form()">
                <button type="submit" class="underline underline-offset-4">
                    Utiliser un autre compte
                </button>
            </Form>
        </div>
    </div>
</template>
