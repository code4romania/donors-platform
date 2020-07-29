<template>
    <layout>
        <template v-slot:title>
            {{ $t('auth.register') }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-6">
            <form-input
                type="text"
                id="name"
                :label="$t('account.name')"
                v-model="form.name"
                :errors="$page.errors.name"
                required
                autocomplete="name"
                autofocus
            />

            <form-input
                type="email"
                id="email"
                :label="$t('account.email')"
                v-model="form.email"
                :errors="$page.errors.email"
                required
                autocomplete="email"
            />

            <form-input
                type="password"
                id="password"
                :label="$t('account.password')"
                v-model="form.password"
                :errors="$page.errors.password"
                required
                autocomplete="new-password"
            />

            <form-input
                type="password"
                id="password_confirmation"
                :label="$t('account.password_confirmation')"
                v-model="form.password_confirmation"
                :errors="$page.errors.password_confirmation"
                required
                autocomplete="new-password"
            />

            <form-button color="blue" type="submit">
                {{ $t('auth.register') }}
            </form-button>
        </form>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout/Auth';
    import FormInput from '@/Shared/Form/Input';
    import FormButton from '@/Shared/Form/Button';

    export default {
        components: {
            Layout,
            FormInput,
            FormButton,
        },
        data() {
            return {
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                },
            };
        },
        methods: {
            submit() {
                this.$inertia.post(this.$route('register'), this.form);
            },
        },
    };
</script>
