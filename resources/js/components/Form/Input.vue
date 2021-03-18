<template>
    <div class="space-y-4">
        <template v-if="translated && locales">
            <div v-for="(_, locale) in locales" :key="locale">
                <div class="flex mb-1">
                    <span
                        class="px-1.5 mr-2 text-xs text-white uppercase bg-gray-400 rounded-sm"
                        v-text="locale"
                    />

                    <form-label
                        v-if="label"
                        :label="label"
                        :id="`${id}_${locale}`"
                        :required="$attrs.required"
                        class="flex-1"
                    />
                </div>

                <div class="relative">
                    <form-text
                        :type="type"
                        :id="`${id}_${locale}`"
                        :autofocus="$attrs.autofocus && isCurrentLocale(locale)"
                        v-bind="$attrs"
                        v-model="dataValue[locale]"
                        @input="update(locale, ...arguments)"
                        :class="{ 'pr-13': suffix }"
                    />

                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 pointer-events-none sm:text-sm sm:leading-5"
                        v-if="suffix"
                        v-text="suffix"
                    />
                </div>

                <form-input-error :id="id" :locale="locale" />
            </div>
        </template>

        <div v-else>
            <div class="flex mb-1">
                <form-label
                    v-if="label"
                    :label="label"
                    :id="id"
                    :required="$attrs.required"
                />

                <form-help v-if="help" :text="help" class="ml-2" />
            </div>

            <div class="relative">
                <form-text
                    :type="type"
                    :id="id"
                    v-bind="$attrs"
                    v-model="dataValue"
                    @input="update(false, ...arguments)"
                    :class="{ 'pr-13': suffix }"
                />

                <div
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 pointer-events-none sm:text-sm sm:leading-5"
                    v-if="suffix"
                    v-text="suffix"
                />
            </div>
            <form-input-error :id="id" />
        </div>
    </div>
</template>

<script>
    import LocaleMixin from '@/mixins/locale';

    export default {
        name: 'FormInput',
        inheritAttrs: false,
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
            suffix: {
                type: String,
                default: null,
            },
            help: {
                type: String,
                default: null,
            },
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
