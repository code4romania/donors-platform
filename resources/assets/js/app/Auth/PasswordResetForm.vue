<template>
    <layout-auth>
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

            <form-input
                type="password"
                id="password"
                :label="$t('dashboard.field.password')"
                v-model="form.password"
                required
                autocomplete="new-password"
            />
            <form-input
                type="password"
                id="password_confirmation"
                :label="$t('dashboard.field.password_confirmation')"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
            />

            <form-button color="blue" type="submit">
                {{ $t('auth.reset') }}
            </form-button>
        </form>
    </layout-auth>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    token: this.$page.token,
                    email: this.$page.email,
                    password: null,
                    password_confirmation: null,
                },
            };
        },
        methods: {
            submit() {
                this.$inertia.post(this.$route('password.update'), this.form);
            },
        },
    };
</script>
