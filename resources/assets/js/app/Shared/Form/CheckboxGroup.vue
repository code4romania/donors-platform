<template>
    <div>
        <form-label :id="id" :label="label" />

        <div class="flex flex-wrap leading-tight text-gray-900">
            <label
                class="flex items-center w-full py-2 pr-3 sm:w-1/2 md:w-1/3 lg:w-1/4"
                v-for="(option, index) in options"
                :key="index"
            >
                <input
                    type="checkbox"
                    class="w-4 h-4 mr-2 text-blue-500 duration-150 ease-in-out transition-color form-checkbox"
                    :value="option"
                    v-model="checked"
                />
                {{ option }}
            </label>

            <label
                class="flex items-center w-full py-2 pr-3 sm:w-1/2 md:w-1/3 lg:w-1/4"
                v-if="otherLabel"
            >
                <input
                    type="checkbox"
                    class="w-4 h-4 mr-2 transition duration-150 ease-in-out form-checkbox"
                    :class="disableOther ? 'text-gray-200' : 'text-blue-500'"
                    v-model="showOther"
                    :disabled="disableOther"
                />
                {{ otherLabel }}
            </label>
        </div>

        <form-input
            v-if="showOther"
            type="text"
            id="other"
            :label="otherLabel"
            v-model="other"
            :errors="$page.errors.other"
        />

        <input-error v-if="errors.length" :message="errors" />
    </div>
</template>

<script>
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormInput from '@/Shared/Form/Input';
    import FormLabel from '@/Shared/Form/Label';
    import InputError from '@/Shared/Form/InputError';

    export default {
        inheritAttrs: false,
        components: {
            FormCheckbox,
            FormInput,
            FormLabel,
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
                showOther: false,
                other: null,
            };
        },
        computed: {
            disableOther() {
                return !!(this.other && this.other.length);
            },
            checkedOptions() {
                return [...this.checked, this.other].filter((el) => el !== null);
            },
        },
        watch: {
            checkedOptions(cv) {
                this.$emit('input', cv);
            },
        },
    };
</script>
