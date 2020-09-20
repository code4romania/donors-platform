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

        <form @submit.prevent="submit" method="post" class="grid gap-y-6">
            <form-input
                type="password"
                id="password"
                :label="$t('field.password')"
                v-model="form.password"
                required
                autocomplete="new-password"
            />
            <form-input
                type="password"
                id="password_confirmation"
                :label="$t('field.password_confirmation')"
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
        props: {
            user: Object,
        },
        data() {
            return {
                form: {
                    email: this.user.email,
                    password: null,
                    password_confirmation: null,
                },
            };
        },
        methods: {
            submit() {
                this.$inertia.post(
                    location.href,
                    // this.$route('welcome', { user: this.user.id }),
                    this.form
                );
            },
        },
    };
</script>
