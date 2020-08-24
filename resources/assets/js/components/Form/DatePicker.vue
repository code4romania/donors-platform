<template>
    <div>
        <form-label
            v-if="label"
            :label="label"
            :id="id"
            :required="$attrs.required"
            class="flex-1"
        />

        <div class="relative">
            <flat-pickr
                v-model="dataValue"
                class="block w-full pr-10 transition duration-150 ease-in-out rounded-md shadow-sm form-input"
                :config="config"
            />

            <span
                class="absolute inset-y-0 flex items-center leading-none pointer-events-none right-2"
            >
                <svg-vue
                    icon="Business/calendar-line"
                    class="w-5 h-5 text-gray-400 fill-current"
                />
            </span>
        </div>

        <form-input-error :id="id" />
    </div>
</template>

<script>
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    import { Romanian } from 'flatpickr/dist/l10n/ro.js';

    export default {
        name: 'FormDatePicker',
        inheritAttrs: false,
        components: {
            FlatPickr,
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
            checked: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Array,
                default: () => [],
            },
            value: {},
        },
        computed: {
            localizedMonths() {
                return this.$t('calendar.month');
            },
            localizedDays() {
                return this.$t('calendar.day');
            },
        },
        data() {
            let defaultLocale = { firstDayOfWeek: 1 };

            return {
                dataValue: this.value,
                config: {
                    locale: this.$page.locale === 'ro' ? Romanian : defaultLocale,
                },
            };
        },
        watch: {
            value: {
                immediate: true,
                handler: function (newValue) {
                    this.dataValue = newValue;
                },
            },
            dataValue(newValue) {
                this.$emit('input', newValue);
            },
        },
    };
</script>
