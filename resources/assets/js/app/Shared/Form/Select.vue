<template>
    <div>
        <label
            v-if="label"
            :for="id"
            class="block mb-1 font-semibold leading-tight text-gray-700"
            v-text="label"
        />

        <select
            :id="id"
            class="block w-full border-gray-300 form-select focus:outline-none focus:shadow-outline-blue focus:border-blue-300"
            v-bind="$attrs"
            @change="$emit('input', $event.target.value)"
        >
            <option
                v-for="(option, index) in options"
                :checked="dataValue === option"
                :key="index"
                v-text="option"
            />
        </select>

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
            options: {
                type: Array,
                default: () => [],
            },
            errors: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                dataValue: this.value,
            };
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    this.dataValue = newValue;
                },
            },
        },
    };
</script>
