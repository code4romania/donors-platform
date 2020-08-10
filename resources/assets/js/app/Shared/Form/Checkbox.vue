<template>
    <div class="flex items-center">
        <input
            type="checkbox"
            :id="id"
            class="w-4 h-4 mb-1 text-blue-600 transition duration-150 ease-in-out form-checkbox"
            :value="value"
            v-model="checked"
        />

        <form-label :id="id" :label="label || value" class="ml-2" />

        <input-error :id="id" />
    </div>
</template>

<script>
    import FormLabel from '@/Shared/Form/Label';
    import InputError from '@/Shared/Form/InputError';

    export default {
        inheritAttrs: false,
        components: {
            FormLabel,
            InputError,
        },
        props: {
            value: {
                type: [String, Boolean],
                default: false,
            },
            label: {
                type: [String, null],
                default: null,
            },
            id: {
                type: String,
                required: true,
            },
            errors: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                checked: false,
            };
        },
        watch: {
            value: {
                immediate: true,
                handler: function (value) {
                    this.checked = value;
                },
            },
            checked(cv) {
                this.$emit('input', cv);
            },
        },
    };
</script>
