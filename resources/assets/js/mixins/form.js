import LocaleMixin from '@/mixins/locale';

export default {
    mixins: [LocaleMixin],
    data() {
        return {
            sending: false,
            formAction: null,
            form: {
                _method: 'POST',
                _publish: true,
            },
        };
    },
    computed: {
        createLabel() {
            return this.$t('dashboard.action.create');
        },
        deleteLabel() {
            return this.$t('dashboard.action.delete');
        },
        saveLabel() {
            return this.$t('dashboard.action.save');
        },

        visibilityLabel() {
            return this.$t(
                this.form._publish
                    ? 'dashboard.action.unpublish'
                    : 'dashboard.action.publish'
            );
        },
    },
    methods: {
        isObject: value => value === Object(value),

        prepareFields(fields, model) {
            let prepared = {};

            fields.forEach(field => {
                if (this.isTranslatableField(field)) {
                    prepared[field] = {};
                    Object.keys(this.$page.locales).forEach(locale => {
                        if (!this.isObject(model)) {
                            prepared[field][locale] = null;
                            return;
                        }

                        let translation = model.translations.find(
                            translation => translation.locale === locale
                        );

                        prepared[field][locale] = translation
                            ? translation[field] || null
                            : null;
                    });
                } else {
                    prepared[field] = this.isObject(model)
                        ? model[field] || null
                        : null;
                }
            });

            return prepared;
        },
        prepareFormData(originalFields) {
            let fields = { ...originalFields },
                locales = {};

            if (!this.translatable.length) {
                return fields;
            }

            this.translatable.forEach(field => {
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
        submit() {
            if (!this.formAction) {
                throw Error('formAction is not configured.');
            }

            if (this.sending) {
                return;
            }

            this.sending = true;

            this.$inertia
                .post(this.formAction, this.prepareFormData(this.form))
                .then(() => (this.sending = false));
        },
        changeVisibility() {
            this.form._publish = !this.form._publish;
            this.submit();
        },
    },
};
