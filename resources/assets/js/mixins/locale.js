export default {
    computed: {
        locale() {
            return this.$page.locale;
        },
        locales() {
            return this.$page.locales;
        },
        localeOptions() {
            return Object.keys(this.locales).map(locale => ({
                value: locale,
                label: this.locales[locale],
            }));
        },
        translatable() {
            return this.$page.translatable || [];
        },
    },
    methods: {
        isValidLocale(locale) {
            return this.$page.locales.hasOwnProperty(locale);
        },
        isCurrentLocale(locale) {
            return this.$page.locale === locale;
        },
        isTranslatableField(field) {
            return (this.$page.translatable || []).indexOf(field) >= 0;
        },
        changeLocale(locale) {
            if (!this.isValidLocale(locale)) {
                return;
            }

            this.$page.locale = locale;
        },
        nextLocale() {
            let keys = Object.keys(this.$page.locales),
                nextLocale = keys[keys.indexOf(this.locale) + 1] || keys[0];

            this.changeLocale(nextLocale);
        },
    },
};
