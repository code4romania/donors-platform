<template>
    <div>
        <label
            v-if="label"
            :for="id"
            class="block mb-1 font-semibold leading-tight text-gray-700"
            v-text="label"
        />

        <input
            :type="type"
            :id="id"
            class="block w-full transition duration-150 ease-in-out rounded-md shadow-sm form-input"
            v-bind="$attrs"
            @input="$emit('input', $event.target.value)"
        />

        <input-error v-if="errors.length" :message="errors[0]" />
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
            label: {
                type: [String, null],
                default: null,
            },
            id: {
                type: String,
                required: true,
            },
            type: {
                type: String,
                default: 'text',
            },
            errors: {
                type: Array,
                default: () => [],
            },
        },
    };
</script>
