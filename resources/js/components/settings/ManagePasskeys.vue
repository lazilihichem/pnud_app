<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { KeyRound } from '@lucide/vue';
import type { Passkey } from '@/types/auth';
import Heading from '@/components/typography/Heading.vue';
import PasskeyItem from '@/components/settings/PasskeyItem.vue';
import PasskeyRegister from '@/components/settings/PasskeyRegister.vue';
import { destroy } from '@/actions/Laravel/Passkeys/Http/Controllers/PasskeyRegistrationController';

export type Props = {
    canManagePasskeys?: boolean;
    passkeys?: Passkey[];
};

withDefaults(defineProps<Props>(), {
    canManagePasskeys: false,
    passkeys: () => [],
});

const { t } = useI18n();

const handleDelete = (id: number, onError: () => void) => {
    router.delete(destroy.url({ passkey: id }), {
        preserveScroll: true,
        onError,
    });
};

const handleRegisterSuccess = () => {
    router.reload();
};
</script>

<template>
    <div v-if="canManagePasskeys" class="space-y-6">
        <Heading
            variant="small"
            :title="t('passkeys.title')"
            :description="t('passkeys.description')"
        />

        <div class="overflow-hidden rounded-lg border border-border">
            <template v-if="passkeys.length">
                <PasskeyItem
                    v-for="passkey in passkeys"
                    :key="passkey.id"
                    :passkey="passkey"
                    @remove="handleDelete"
                />
            </template>

            <div v-else class="p-8 text-center">
                <div
                    class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-muted"
                >
                    <KeyRound class="h-7 w-7 text-muted-foreground" />
                </div>
                <p class="font-medium">{{ t('passkeys.emptyTitle') }}</p>
                <p class="mt-1 text-sm text-muted-foreground">
                    {{ t('passkeys.emptyDescription') }}
                </p>
            </div>
        </div>

        <PasskeyRegister @success="handleRegisterSuccess" />
    </div>
</template>
