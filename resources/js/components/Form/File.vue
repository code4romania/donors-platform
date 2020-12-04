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
            class="block w-full text-xs transition duration-150 ease-in-out rounded-md shadow-sm form-input"
            :accept="accept"
            v-bind="$attrs"
            @change="onChange"
        />

        <form-input-error :id="id" />
    </div>
</template>

<script>
    export default {
        name: 'FormFile',
        inheritAttrs: false,
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            accept: {
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
                this.file = e.target.files[0];
                this.$emit('fileChange', this.file);
            },
        },
    };
</script>
