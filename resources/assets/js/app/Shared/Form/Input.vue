<template>
    <div>
        <div class="flex">
            <form-label
                v-if="label"
                :label="label"
                :id="id"
                :required="$attrs.required"
                class="flex-1"
            />

            <button
                v-if="translated && locales"
                type="button"
                class="px-1.5 mb-1 ml-2 text-xs text-white uppercase bg-gray-400 rounded-sm hover:bg-gray-500 focus:outline-none"
                @click="nextLocale"
                v-text="locale"
            />
        </div>

        <template v-if="translated && locales">
            <form-text
                v-for="(_, locale) in locales"
                v-show="isCurrentLocale(locale)"
                :key="locale"
                :type="type"
                :id="id"
                v-bind="$attrs"
                v-model="dataValue[locale]"
                @input="update(locale, ...arguments)"
            />
        </template>
        <template v-else>
            <form-text
                :type="type"
                :id="id"
                v-bind="$attrs"
                v-model="dataValue"
                @input="update(false, ...arguments)"
            />
        </template>

        <input-error :id="id" :translated="translated" />
    </div>
</template>

<script>
    import FormLabel from '@/Shared/Form/Label';
    import FormText from '@/Shared/Form/Text';
    import InputError from '@/Shared/Form/InputError';

    import LocaleMixin from '@/mixins/locale';

    export default {
        inheritAttrs: false,
        components: {
            FormLabel,
            FormText,
            InputError,
        },
        mixins: [LocaleMixin],
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
            translated: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Array,
                default: () => [],
            },
            value: {},
        },
        data() {
            return {
                dataValue: this.value,
            };
        },
        methods: {
            update(locale, value) {
                let payload = {};

                if (locale) {
                    payload = {
                        ...this.dataValue,
                        [locale]: value,
                    };
                } else {
                    payload = this.dataValue;
                }

                this.$emit('input', payload);
            },
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
