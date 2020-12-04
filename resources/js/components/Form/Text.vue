<template>
    <textarea
        v-if="type === 'textarea'"
        :id="id"
        class="block w-full transition duration-150 ease-in-out rounded-md shadow-sm form-textarea"
        v-bind="$attrs"
        v-model="dataValue"
    />
    <input
        v-else
        :type="type"
        :id="id"
        class="block w-full transition duration-150 ease-in-out rounded-md shadow-sm form-input"
        v-bind="$attrs"
        v-model="dataValue"
    />
</template>

<script>
    export default {
        name: 'FormText',
        props: {
            id: {
                type: String,
                required: true,
            },
            type: {
                type: String,
                default: 'text',
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
                handler(newValue) {
                    this.dataValue = newValue;
                },
            },
            dataValue(newValue) {
                this.$emit('input', newValue);
            },
        },
    };
</script>
