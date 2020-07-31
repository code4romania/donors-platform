<template>
    <div class="flex items-center">
        <input
            type="checkbox"
            :id="id"
            :checked="isChecked"
            class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-checkbox"
            :value="value"
            @change="onChange"
        />
        <form-label :id="id" :label="label || value" />

        <input-error v-if="errors.length" :message="errors" />
    </div>
</template>

<script>
    import FormLabel from '@/Shared/Form/Label';
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
        computed: {
            isGroup() {
                return this.$parent.$options.name === 'CheckboxGroup';
            },
            isChecked() {
                if (!this.isGroup) {
                    return this.checked;
                }

                if (this.$parent.modelValue) {
                    if (typeof this.value === 'object') {
                        return !!this.$parent.modelValue.find(
                            (item) => item.id === this.value.id
                        );
                    }

                    if (
                        typeof this.value === 'string' ||
                        typeof this.value === 'number'
                    ) {
                        return !!this.$parent.modelValue.find(
                            (item) => item === this.value
                        );
                    }
                }

                return false;
            },
        },
        methods: {
            onChange() {
                if (this.disabled) {
                    return;
                }

                if (!this.isGroup) {
                    return this.$emit('change', !this.checked);
                }

                if (!this.isChecked) {
                    this.$parent.value.push(this.value);
                } else {
                    this.$parent.value.find((item) => {
                        if (typeof this.value === 'object') {
                            this.$nextTick(() => {
                                if (item.id === this.value.id)
                                    this.$parent.value.splice(
                                        this.$parent.value.indexOf(item),
                                        1
                                    );
                            });
                        }
                        if (
                            typeof this.value === 'string' ||
                            typeof this.value === 'number'
                        ) {
                            this.$nextTick(() => {
                                if (item === this.value)
                                    this.$parent.value.splice(
                                        this.$parent.value.indexOf(item),
                                        1
                                    );
                            });
                        }
                    });
                }
            },
        },
    };
</script>
