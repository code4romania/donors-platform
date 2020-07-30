<template>
    <div>
        <label
            :for="id"
            class="block mb-1 font-semibold leading-tight text-gray-700"
            v-text="label"
        />

        <div class="flex space-x-4">
            <div
                class="flex items-center"
                v-for="(option, index) in options"
                :key="index"
            >
                <input
                    type="checkbox"
                    :id="id"
                    class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-checkbox"
                    :value="option"
                    v-model="checked"
                />
                <label
                    :for="id"
                    class="block ml-2 leading-tight text-gray-900"
                    v-text="option"
                />
            </div>

            <form-input
                v-if="otherLabel"
                type="text"
                id="other"
                :label="otherLabel"
                v-model="other"
                :errors="$page.errors.other"
                required
                autofocus
            />

            <input-error v-if="errors.length" :message="errors" />
        </div>
    </div>
</template>

<script>
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormInput from '@/Shared/Form/Input';
    import InputError from '@/Shared/Form/InputError';

    export default {
        name: 'CheckboxGroup',
        inheritAttrs: false,
        components: {
            FormCheckbox,
            FormInput,
            InputError,
        },
        props: {
            label: {
                type: [String, null],
                default: null,
            },
            otherLabel: {
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
                checked: [],

                other: null,
            };
        },
        computed: {
            computedValue() {
                return [...this.checked, this.other].filter(null);
            },
        },
    };
</script>
