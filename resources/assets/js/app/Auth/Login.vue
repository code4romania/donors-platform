<template>
    <layout>
        <template v-slot:title>
            {{ $t('auth.login') }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-6">
            <form-input
                type="email"
                id="email"
                :label="$t('dashboard.field.email')"
                v-model="form.email"
                required
                autocomplete="email"
                autofocus
            />

            <form-input
                type="password"
                id="password"
                :label="$t('dashboard.field.password')"
                v-model="form.password"
                required
                autocomplete="current-password"
            />

            <div class="flex items-center justify-between">
                <form-checkbox
                    id="remember"
                    :checked.sync="form.remember"
                    :label="$t('auth.remember')"
                />

                <inertia-link
                    :href="$route('password.request')"
                    class="font-semibold leading-tight text-blue-500 hover:text-blue-600 focus:outline-none focus:underline"
                    v-text="$t('auth.forgot')"
                />
            </div>

            <form-button color="blue" type="submit">
                {{ $t('auth.login') }}
            </form-button>
        </form>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout/Auth';
    import FormInput from '@/Shared/Form/Input';
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormButton from '@/Shared/Form/Button';

    export default {
        components: {
            Layout,
            FormInput,
            FormCheckbox,
            FormButton,
        },
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                    remember: false,
                },
            };
        },
        methods: {
            submit() {
                this.$inertia.post(this.$route('login'), this.form);
            },
        },
    };
</script>
