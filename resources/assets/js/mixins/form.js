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
        draftLabel() {
            return this.$t('dashboard.action.draft');
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
        isObject: value => value !== null && value === Object(value),
        isFile: value => value instanceof File,
        formatAmount: value => (value !== null ? value.amount / 100 : null),
        clamp: (x, min, max) => Math.min(Math.max(x, min), max),

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
                let value = '';

                if (this.isObject(data[field]) && !this.isFile(data[field])) {
                    value = JSON.stringify(data[field]);
                } else if (typeof data[field] === 'boolean') {
                    value = data[field] ? 1 : 0;
                } else if (null !== data[field]) {
                    value = data[field];
                }

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
        publish() {
            this.form._publish = true;
            this.submit();
        },
        draft() {
            this.form._publish = false;
            this.submit();
        },
        changeVisibility() {
            this.form._publish = !this.form._publish;
            this.submit();
        },
        destroy() {
            if (!this.deleteAction) {
                throw Error('deleteAction is not configured.');
            }

            if (this.sending) {
                return;
            }

            if (!confirm(this.$t('dashboard.action.deleteConfirm'))) {
                return;
            }

            this.sending = true;

            this.$inertia
                .delete(this.deleteAction)
                .then(() => (this.sending = false));
        },
    },
};
