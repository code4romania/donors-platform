export default {
    computed: {
        locale() {
            return this.$page.locale;
        },
        locales() {
            return this.$page.locales;
        },
    },
    methods: {
        isValidLocale(locale) {
            return this.$page.locales.hasOwnProperty(locale);
        },
        isCurrentLocale(locale) {
            return this.$page.locale === locale;
        },
        changeLocale(locale) {
            if (!this.isValidLocale(locale)) {
                return;
            }

            this.$page.locale = locale;
        },
        nextLocale() {
            let keys = Object.keys(this.$page.locales),
                currentIndex = keys.indexOf(this.$page.locale),
                nextLocale = keys[currentIndex + 1] || keys[0];

            this.changeLocale(nextLocale);
        },
        maybeLocalizeField(fieldName, model) {
            if (
                !this.$page.hasOwnProperty('translatable') ||
                this.$page.translatable.indexOf(fieldName) === -1
            ) {
                return typeof model === 'object'
                    ? model[fieldName] || null
                    : null;
            }

            let field = {};
            Object.keys(this.$page.locales).forEach(locale => {
                field[locale] =
                    typeof model === 'object'
                        ? model.translations.filter(
                              translation => translation.locale === locale
                          )[0][fieldName] || null
                        : null;
            });

            return field;
        },
        prepareFields(fields, model) {
            let prepared = {};

            fields.forEach(field => {
                prepared[field] = this.maybeLocalizeField(field, model);
            });

            return prepared;
        },
        prepareFormData(originalFields) {
            let fields = { ...originalFields },
                locales = {};

            if (!this.$page.hasOwnProperty('translatable')) {
                return fields;
            }

            this.$page.translatable.forEach(field => {
                Object.keys(this.$page.locales).forEach(locale => {
                    if (!locales.hasOwnProperty(locale)) {
                        locales[locale] = {};
                    }

                    locales[locale][field] = fields[field][locale];
                });

                delete fields[field];
            });

            let data = { ...fields, ...locales },
                formData = new FormData();

            for (const field in data) {
                let value = this.isObject(data[field])
                    ? JSON.stringify(data[field])
                    : data[field];

                formData.append(field, value);
            }

            return formData;
        },
        isObject(value) {
            return value === Object(value);
        },
    },
};
