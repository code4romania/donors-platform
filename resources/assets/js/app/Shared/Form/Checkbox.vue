<template>
    <div class="flex items-center">
        <input
            type="checkbox"
            :id="id"
            class="w-4 h-4 mb-1 text-blue-600 transition duration-150 ease-in-out form-checkbox"
            :value="value"
            :checked="checked"
            @change="$emit('update:checked', $event.target.checked)"
        />

        <form-label :id="id" :label="label || value" class="ml-2" />

        <input-error v-if="errors.length" :message="errors" />
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
            value: {
                type: [String, Boolean],
                default: false,
            },
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
        },
    };
</script>
