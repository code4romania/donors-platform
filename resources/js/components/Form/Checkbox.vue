<template>
    <div>
        <div class="flex items-center">
            <input
                type="checkbox"
                :id="id"
                class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                :value="value"
                v-model="checked"
            />

            <form-label :id="id" :label="label || value" class="ml-2" />
        </div>

        <form-input-error :id="id" />
    </div>
</template>

<script>
    export default {
        name: 'FormCheckbox',
        inheritAttrs: false,
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
