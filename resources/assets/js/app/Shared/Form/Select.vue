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
                v-for="(option, index) in options"
                :key="index"
                :checked="dataSelected === option"
                :value="option[optionValueKey] || option"
                v-text="option[optionLabelKey] || option"
            />
        </select>

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
            multiple: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                dataSelected: [],
            };
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
