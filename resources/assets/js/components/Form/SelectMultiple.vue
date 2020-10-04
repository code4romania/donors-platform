<template>
    <dropdown button-class="w-full text-left form-select">
        <div class="flex justify-between">
            <span class="flex-1 truncate" v-text="label" />
            <span
                v-if="checked.length"
                v-text="`(${checked.length})`"
                class="flex-shrink-0 ml-2 text-gray-600"
            />
        </div>

        <div slot="dropdown">
            <label
                class="flex w-full px-4 py-2 cursor-pointer hover:bg-gray-100"
                v-for="(option, index) in options"
                :key="index"
            >
                <input
                    type="checkbox"
                    class="w-4 h-4 mt-1 mr-2 text-blue-500 duration-150 ease-in-out transition-color form-checkbox"
                    :value="option[optionValueKey] || option"
                    v-model="checked"
                />
                {{ option[optionLabelKey] || option }}
            </label>
        </div>

        <form-input-error :id="id" />
    </dropdown>
</template>

<script>
    export default {
        name: 'FormSelectMultiple',
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
            optionPlaceholder: {
                type: [String, null],
                default: null,
            },
            multiple: {
                type: Boolean,
                default: false,
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
