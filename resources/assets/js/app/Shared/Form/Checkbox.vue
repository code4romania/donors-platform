<template>
    <div class="flex items-center">
        <input
            type="checkbox"
            :id="id"
            class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-checkbox"
            :value="value"
            @change="$emit('change', $event.target.checked)"
        />
        <label
            :for="id"
            class="block ml-2 leading-tight text-gray-900"
            v-text="label || value"
        />

        <input-error v-if="errors.length" :message="errors" />
    </div>
</template>

<script>
    import InputError from '@/Shared/Form/InputError';

    export default {
        inheritAttrs: false,
        components: {
            InputError,
        },
        props: {
            value: {
                type: [String, null],
                default: null,
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
    };
</script>
