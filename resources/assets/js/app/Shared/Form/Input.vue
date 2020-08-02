<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
        />

        <template v-if="translated && languages">
            <template v-for="(name, locale) in languages" v-show="true">
                <form-text
                    :key="locale"
                    :type="type"
                    :id="id"
                    v-bind="$attrs"
                    v-model="dataValue[locale]"
                    @input="update(locale, ...arguments)"
                />
            </template>
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
        <input-error v-if="errors.length" :message="errors[0]" />
    </div>
</template>

<script>
    import FormLabel from '@/Shared/Form/Label';
    import FormText from '@/Shared/Form/Text';
    import InputError from '@/Shared/Form/InputError';

    export default {
        inheritAttrs: false,
        components: {
            FormLabel,
            FormText,
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
        computed: {
            languages() {
                return this.$page.languages;
            },
            availableLocales() {
                return Object.keys(this.$page.languages);
            },
        },
        methods: {
            isValidLocale(locale) {
                return this.availableLocales.indexOf(locale) !== -1;
            },
            changeLanguage(locale) {
                if (!this.isValidLocale(locale)) {
                    return;
                }

                this.$page.locale = locale;
            },
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
