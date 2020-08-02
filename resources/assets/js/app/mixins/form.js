export default {
    props: {
        locale: {
            default: null,
        },
    },
    computed: {},
    methods: {
        changeLanguage(locale) {
            // if (!this.isValidLocale(locale)) {
            //     return;
            // }
            this.$page.locale = locale;
        },
        localizeField(fieldName, model) {
            if (
                !model.hasOwnProperty('translatable') ||
                model.translatable.indexOf(fieldName) === -1
            ) {
                return model[fieldName];
            }

            let field = {};
            Object.keys(this.$page.languages).forEach(locale => {
                field[locale] =
                    model.translations.filter(
                        translation => translation.locale === locale
                    )[0][fieldName] || null;
            });

            return field;
        },
        prepareData(originalFields, model) {
            let fields = { ...originalFields },
                locales = {};

            if (!model.hasOwnProperty('translatable')) {
                return fields;
            }

            model.translatable.forEach(field => {
                Object.keys(this.$page.languages).forEach(locale => {
                    if (!locales.hasOwnProperty(locale)) {
                        locales[locale] = {};
                    }

                    locales[locale][field] = fields[field][locale];
                });

                delete fields[field];
            });

            return { ...fields, ...locales };
        },
    },
};
