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
            locale: {
                type: [String, null],
                default: null,
            },
        },
        computed: {
            errorKey() {
                return this.locale ? `${this.locale}.${this.id}` : this.id;
            },
            hasErrors() {
                if (!this.hasOwnProperty('$page')) {
                    return false;
                }

                return this.$page.props.errors.hasOwnProperty(this.errorKey);
            },
            message() {
                if (!this.hasErrors) {
                    return null;
                }

                return this.$page.props.errors[this.errorKey];
            },
        },
        methods: {},
    };
</script>
