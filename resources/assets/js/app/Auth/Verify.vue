<template>
    <layout-auth>
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
    </layout-auth>
</template>

<script>
    export default {
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
