<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
        />

        <input
            type="file"
            :id="id"
            class="block w-full transition duration-150 ease-in-out rounded-md shadow-sm form-input"
            ref="file"
            v-bind="$attrs"
            @change="onChange"
        />

        <input-error v-if="errors.length" :message="errors[0]" />
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
            errors: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                file: null,
            };
        },
        methods: {
            onChange(e) {
                this.$emit('fileChange', e.target.files[0]);
                this.file = e.target.files[0];
            },
        },
    };
</script>
