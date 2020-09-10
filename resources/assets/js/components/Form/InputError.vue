<template>
    <span
        v-if="hasErrors"
        class="mt-2 text-sm text-red-600"
        role="alert"
        v-text="message"
    />
</template>

<script>
    export default {
        name: 'FormInputError',
        props: {
            id: {
                type: String,
                required: true,
            },
            translated: {
                type: Boolean,
                required: false,
            },
        },
        computed: {
            errorKey() {
                return this.translated
                    ? `${this.$page.locale}.${this.id}`
                    : this.id;
            },
            hasErrors() {
                return this.$page.errors.hasOwnProperty(this.errorKey);
            },
            message() {
                if (!this.hasErrors) {
                    return null;
                }

                return this.$page.errors[this.errorKey];
            },
        },
        methods: {},
    };
</script>
