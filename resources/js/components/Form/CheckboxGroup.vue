<template>
    <div>
        <form-label :id="id" :label="label" class="mb-1" />

        <div class="flex flex-wrap leading-tight text-gray-900">
            <label
                class="flex w-full py-2 pr-3 sm:w-1/2 lg:w-1/4"
                v-for="(option, index) in options"
                :key="index"
            >
                <input
                    type="checkbox"
                    class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    :value="option[optionValueKey]"
                    v-model="checked"
                />
                {{ option[optionLabelKey] }}
            </label>
        </div>

        <form-input-error :id="id" />
    </div>
</template>

<script>
    export default {
        name: 'FormCheckboxGroup',
        inheritAttrs: false,
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            id: {
                type: String,
                required: true,
            },
            options: {
                type: Array,
                default: () => [],
            },
            optionValueKey: {
                type: String,
                default: 'value',
            },
            optionLabelKey: {
                type: String,
                default: 'label',
            },
            errors: {
                type: Array,
                default: () => [],
            },
            value: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                checked: [],
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
