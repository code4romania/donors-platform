<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
        />

        <select
            :id="id"
            class="block w-full border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300"
            :class="{
                'form-select': !this.multiple,
                'form-multiselect': this.multiple,
            }"
            :multiple="multiple"
            v-bind="$attrs"
            v-model="dataSelected"
        >
            <option
                v-if="optionPlaceholder"
                :value="null"
                v-text="optionPlaceholder"
            />

            <template v-for="(option, index) in options">
                <option
                    :key="index"
                    :checked="dataSelected === option"
                    :value="optionValue(option)"
                    v-html="optionLabel(option)"
                />

                <template v-for="(option, l1Index) in option.children">
                    <option
                        :key="index + '-' + l1Index"
                        :value="optionValue(option)"
                        v-html="optionLabel(option)"
                    />

                    <option
                        v-for="(option, l2Index) in option.children"
                        :key="index + '-' + l1Index + '-' + l2Index"
                        :value="optionValue(option)"
                        v-html="optionLabel(option)"
                    />
                </template>
            </template>
        </select>

        <form-input-error :id="id" />
    </div>
</template>

<script>
    export default {
        name: 'FormSelect',
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
            value: {},
        },
        data() {
            return {
                dataSelected: [],
            };
        },
        methods: {
            padOption(depth) {
                return '&nbsp;'.repeat(depth);
            },
            optionValue(option) {
                return option[this.optionValueKey] || option;
            },
            optionLabel(option) {
                let prefix = option.depth
                    ? '&nbsp;'.repeat(4 * option.depth) + ' '
                    : '';

                return prefix + (option[this.optionLabelKey] || option);
            },
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    if (typeof newValue !== 'undefined') {
                        this.dataSelected = newValue;
                    }
                },
            },
            dataSelected(cv) {
                this.$emit('input', cv);
            },
        },
    };
</script>
