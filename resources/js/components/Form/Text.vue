<template>
    <textarea
        v-if="type === 'textarea'"
        ref="textarea"
        :id="id"
        :class="style"
        v-bind="$attrs"
        v-model="dataValue"
    />
    <input
        v-else
        :type="type"
        :id="id"
        :class="style"
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
        computed: {
            style() {
                return 'block w-full border-gray-300 rounded-md shadow-sm sm:text-sm disabled:text-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50';
            },
            componentTag() {
                return this.type === 'textarea' ? 'textarea' : 'input';
            },
            componentType() {
                return this.type !== 'textarea' ? this.type : false;
            },
        },
        watch: {
            value: {
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
