<template>
    <label
        :for="id"
        class="block text-sm font-semibold leading-tight text-gray-700"
    >
        {{ label }}
        <span v-if="required" class="font-bold text-red-500">*</span>
    </label>
</template>

<script>
    export default {
        name: 'FormLabel',
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            id: {
                type: String,
                required: true,
            },
            required: {
                type: Boolean,
                default: false,
            },
        },
    };
</script>
