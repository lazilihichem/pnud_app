<script setup lang="ts">
// Functional stub for « Créer un compte » (FR-01). The design comes from the demo later.
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/forms/InputError.vue';
import PasswordInput from '@/components/forms/PasswordInput.vue';
import TextLink from '@/components/typography/TextLink.vue';
import { Button } from '@/components/basic/button';
import { Input } from '@/components/basic/input';
import { Label } from '@/components/basic/label';
import { Spinner } from '@/components/basic/spinner';
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
        title: 'Créer un compte',
        description: 'Choisissez votre profil et complétez vos informations.',
    },
});

// Switching profile unmounts the fields of the previous one, so they are never submitted.
const role = ref('');

// Bound from script: a literal "https://" in a template attribute breaks vue-tsc's slot scope.
const linkedinPlaceholder = 'https://…';

const selectClass =
    'h-9 w-full rounded-md border border-input bg-transparent px-3 text-sm';
</script>

<template>
    <Head title="Créer un compte" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-5">
            <div class="grid gap-2">
                <Label for="role">Je suis *</Label>
                <select
                    id="role"
                    v-model="role"
                    name="role"
                    :class="selectClass"
                >
                    <option value="" disabled>Choisir un profil</option>
                    <option
                        v-for="option in roles"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </option>
                </select>
                <InputError :message="errors.role" />
            </div>

            <div class="grid gap-2">
                <Label for="name">Nom complet *</Label>
                <Input
                    id="name"
                    name="name"
                    autocomplete="name"
                    maxlength="100"
                />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">E-mail *</Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    autocomplete="email"
                    maxlength="254"
                />
                <InputError :message="errors.email" />
                <p v-if="errors.email?.includes('existe déjà')" class="text-sm">
                    <TextLink :href="login()">Se connecter</TextLink>
                    ·
                    <TextLink :href="request()">Mot de passe oublié ?</TextLink>
                </p>
            </div>

            <div class="grid gap-2">
                <Label for="organisation">Organisation</Label>
                <Input
                    id="organisation"
                    name="organisation"
                    autocomplete="organization"
                    maxlength="150"
                />
                <InputError :message="errors.organisation" />
            </div>

            <div class="grid gap-2">
                <Label for="wilaya_id">Wilaya *</Label>
                <select id="wilaya_id" name="wilaya_id" :class="selectClass">
                    <option value="">Choisir une wilaya</option>
                    <option
                        v-for="option in wilayas"
                        :key="option.value"
                        :value="option.value"
                    >
                        {{ option.label }}
                    </option>
                </select>
                <InputError :message="errors.wilaya_id" />
            </div>

            <div v-if="role === 'accompagnateur'" class="grid gap-2">
                <Label for="fonction">Fonction / spécialité *</Label>
                <Input id="fonction" name="fonction" maxlength="150" />
                <InputError :message="errors.fonction" />
            </div>

            <div v-if="role === 'formateur'" class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="linkedin_url">Profil LinkedIn</Label>
                    <Input
                        id="linkedin_url"
                        type="url"
                        name="linkedin_url"
                        :placeholder="linkedinPlaceholder"
                        maxlength="300"
                    />
                    <InputError :message="errors.linkedin_url" />
                </div>

                <div class="grid gap-2">
                    <Label for="education">Formation / diplômes *</Label>
                    <Input id="education" name="education" maxlength="300" />
                    <InputError :message="errors.education" />
                </div>

                <div class="grid gap-2">
                    <Label for="cv">CV * (PDF, DOC, DOCX — 5 Mo maximum)</Label>
                    <input
                        id="cv"
                        type="file"
                        name="cv"
                        accept=".pdf,.doc,.docx"
                        class="text-sm"
                    />
                    <InputError :message="errors.cv" />
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="password">Mot de passe *</Label>
                <PasswordInput
                    id="password"
                    name="password"
                    autocomplete="new-password"
                    :passwordrules="passwordRules"
                />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation"
                    >Confirmer le mot de passe *</Label
                >
                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                    :passwordrules="passwordRules"
                />
            </div>

            <label class="flex items-start gap-2 text-sm">
                <input type="checkbox" name="terms" value="1" class="mt-1" />
                <span
                    >J'accepte les conditions d'utilisation et la politique de
                    confidentialité *</span
                >
            </label>
            <InputError :message="errors.terms" />

            <Button
                type="submit"
                class="w-full"
                :disabled="processing"
                data-test="register-user-button"
            >
                <Spinner v-if="processing" />
                Créer mon compte
            </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
            Déjà inscrit ?
            <TextLink :href="login()" class="underline underline-offset-4"
                >Se connecter</TextLink
            >
        </div>
    </Form>
</template>
