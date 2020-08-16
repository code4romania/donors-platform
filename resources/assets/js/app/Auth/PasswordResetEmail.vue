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
                :label="$t('field.email')"
                v-model="form.email"
                required
                autocomplete="email"
                autofocus
            />

            <form-button color="blue" type="submit">
                {{ $t('auth.send_link') }}
            </form-button>
        </form>
    </layout-auth>
</template>

<script>
    export default {
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
