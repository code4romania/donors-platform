<template>
    <div>
        <div class="flex">
            <form-label
                v-if="label"
                :label="label"
                :id="translated && locales ? `${id}_${locale}` : id"
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

        <div class="relative">
            <template v-if="translated && locales">
                <form-text
                    v-for="(_, locale) in locales"
                    v-show="isCurrentLocale(locale)"
                    :key="locale"
                    :type="type"
                    :id="`${id}_${locale}`"
                    :autofocus="$attrs.autofocus && isCurrentLocale(locale)"
                    v-bind="$attrs"
                    v-model="dataValue[locale]"
                    @input="update(locale, ...arguments)"
                    :class="{ 'pr-13': suffix }"
                />
            </template>
            <template v-else>
                <form-text
                    :type="type"
                    :id="id"
                    v-bind="$attrs"
                    v-model="dataValue"
                    @input="update(false, ...arguments)"
                    :class="{ 'pr-13': suffix }"
                />
            </template>

            <div
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 pointer-events-none sm:text-sm sm:leading-5"
                v-if="suffix"
                v-text="suffix"
            />
        </div>

        <form-input-error :id="id" :translated="translated" />
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
                type: [String, null],
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
