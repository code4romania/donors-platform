<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
            class="mb-1"
        />

        <input
            type="file"
            :id="id"
            class="block w-full px-3 py-1.5 text-xs leading-5 border border-gray-300 rounded-md shadow-sm disabled:text-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:outline-none"
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
