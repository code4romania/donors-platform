<template>
    <layout>
        <template v-slot:title>
            {{ $t('auth.verify.title') }}
        </template>

        <template v-slot:message v-if="$page.resent">
            <Alert>
                {{ $t('auth.verify.resent') }}
            </Alert>
        </template>

        <p class="mb-8 prose">{{ $t('auth.verify.content') }}</p>

        <form-button
            class="w-full"
            color="blue"
            :full-width="true"
            :href="$route('verification.resend')"
            method="post"
        >
            {{ $t('auth.verify.another') }}
        </form-button>
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
                    password: null,
                    remember: null,
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
