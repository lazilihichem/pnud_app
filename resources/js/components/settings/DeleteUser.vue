<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';
import { useI18n } from 'vue-i18n';
import DeleteAccountController from '@/actions/App/Http/Controllers/Accounts/DeleteAccountController';
import Heading from '@/components/typography/Heading.vue';
import InputError from '@/components/forms/InputError.vue';
import PasswordInput from '@/components/forms/PasswordInput.vue';
import { Button } from '@/components/basic/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/basic/dialog';
import { Label } from '@/components/basic/label';

const passwordInput = useTemplateRef('passwordInput');
const { t } = useI18n();
</script>

<template>
    <div class="space-y-6">
        <Heading
            variant="small"
            :title="t('settings.deleteAccount.title')"
            :description="t('settings.deleteAccount.description')"
        />
        <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4">
            <div class="relative space-y-0.5 text-red-600">
                <p class="font-medium">
                    {{ t('settings.deleteAccount.warning') }}
                </p>
                <p class="text-sm">
                    {{ t('settings.deleteAccount.warningDescription') }}
                </p>
            </div>
            <Dialog>
                <DialogTrigger as-child>
                    <Button
                        variant="destructive"
                        data-test="delete-user-button"
                        >{{ t('settings.deleteAccount.title') }}</Button
                    >
                </DialogTrigger>
                <DialogContent>
                    <Form
                        v-bind="DeleteAccountController.form()"
                        reset-on-success
                        @error="() => passwordInput?.focus()"
                        :options="{
                            preserveScroll: true,
                        }"
                        class="space-y-6"
                        v-slot="{ errors, processing, reset, clearErrors }"
                    >
                        <DialogHeader class="space-y-3">
                            <DialogTitle>{{
                                t('settings.deleteAccount.confirmTitle')
                            }}</DialogTitle>
                            <DialogDescription>
                                {{
                                    t(
                                        'settings.deleteAccount.confirmDescription',
                                    )
                                }}
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-2">
                            <Label for="password" class="sr-only">{{
                                t('common.password')
                            }}</Label>
                            <PasswordInput
                                id="password"
                                name="password"
                                ref="passwordInput"
                                :placeholder="t('common.password')"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button
                                    variant="secondary"
                                    @click="
                                        () => {
                                            clearErrors();
                                            reset();
                                        }
                                    "
                                >
                                    {{ t('common.cancel') }}
                                </Button>
                            </DialogClose>

                            <Button
                                type="submit"
                                variant="destructive"
                                :disabled="processing"
                                data-test="confirm-delete-user-button"
                            >
                                {{ t('settings.deleteAccount.title') }}
                            </Button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
