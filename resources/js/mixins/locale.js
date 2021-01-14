import utils from '@/utils';

export default {
    computed: {
        locale() {
            return this.$page.props.locale;
        },
        locales() {
            return this.$page.props.locales;
        },
        localeOptions() {
            return Object.keys(this.locales).map(locale => ({
                value: locale,
                label: this.locales[locale],
            }));
        },
        translatable() {
            return this.$page.props.translatable || [];
        },
    },
    methods: {
        changeLocale(locale) {
            if (!this.isValidLocale(locale)) {
                return;
            }

            this.$page.props.locale = locale;
        },
        nextLocale() {
            let keys = Object.keys(this.$page.props.locales),
                nextLocale = keys[keys.indexOf(this.locale) + 1] || keys[0];

            this.changeLocale(nextLocale);
        },
        isValidLocale(locale) {
            return this.$page.props.locales.hasOwnProperty(locale);
        },
        isCurrentLocale(locale) {
            return this.$page.props.locale === locale;
        },
        isTranslatableField(field) {
            return (this.$page.props.translatable || []).indexOf(field) >= 0;
        },
        translateField(field, model) {
            if (!this.isTranslatableField(field)) {
                return utils.isObject(model) ? model[field] || null : null;
            }

            let translatedField = {};

            Object.keys(this.$page.props.locales).forEach(locale => {
                if (!utils.isObject(model)) {
                    translatedField[locale] = null;
                    return;
                }

                let translation = model.translations.find(
                    translation => translation.locale === locale
                );

                translatedField[locale] = translation
                    ? translation[field] || null
                    : null;
            });

            return translatedField;
        },
        prepareTranslatedFields(fields) {
            let locales = {};

            this.translatable.forEach(field => {
                Object.keys(this.$page.props.locales).forEach(locale => {
                    if (!locales.hasOwnProperty(locale)) {
                        locales[locale] = {};
                    }

                    locales[locale][field] = fields[field][locale];
                });

                delete fields[field];
            });

            return {
                ...fields,
                ...locales,
            };
        },
    },
};
