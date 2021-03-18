<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
            class="flex-1 mb-1"
        />

        <div class="relative">
            <input
                type="date"
                placeholder="YYYY-MM-DD"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                v-model="dataValue"
                v-pattern="{
                    date: true,
                    delimiter: '-',
                    datePattern: ['Y', 'm', 'd'],
                }"
            />
        </div>

        <form-input-error :id="id" />
    </div>
</template>

<script>
    export default {
        name: 'FormDatePicker',
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
            checked: {
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
                dataValue: this.value,
            };
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    this.dataValue = newValue;
                },
            },
            dataValue(newValue) {
                this.$emit('input', newValue);
            },
        },
    };
</script>
