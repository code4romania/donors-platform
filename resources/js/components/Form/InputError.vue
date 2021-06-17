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
                return this.message !== null;
            },
            message() {
                return this.$page.props.errors[this.errorKey] || null;
            },
        },
        methods: {},
    };
</script>
