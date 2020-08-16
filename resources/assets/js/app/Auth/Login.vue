<template>
    <layout-auth>
        <template v-slot:title>
            {{ $t('auth.login') }}
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

            <form-input
                type="password"
                id="password"
                :label="$t('field.password')"
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
    </layout-auth>
</template>

<script>
    export default {
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
