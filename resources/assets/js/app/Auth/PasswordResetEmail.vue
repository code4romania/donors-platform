<template>
    <layout>
        <template v-slot:title>
            {{ $t('auth.reset') }}
        </template>

        <template v-slot:message v-if="$page.status">
            <Alert icon="System/checkbox-circle-fill">
                {{ $page.status }}
            </Alert>
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

            <form-button color="blue" type="submit">
                {{ $t('auth.send_link') }}
            </form-button>
        </form>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout/Auth';
    import FormInput from '@/Shared/Form/Input';
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormButton from '@/Shared/Form/Button';
    import Alert from '@/Shared/Alert';

    export default {
        components: {
            Layout,
            FormInput,
            FormCheckbox,
            FormButton,
            Alert,
        },
        data() {
            return {
                form: {
                    email: null,
                },
            };
        },
        methods: {
            submit() {
                this.$inertia.post(this.$route('password.email'), this.form);
            },
        },
    };
</script>
