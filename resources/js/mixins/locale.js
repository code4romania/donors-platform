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
        isValidLocale(locale) {
            return this.$page.props.locales.hasOwnProperty(locale);
        },
        isCurrentLocale(locale) {
            return this.$page.props.locale === locale;
        },
        isTranslatableField(field) {
            return (this.$page.props.translatable || []).indexOf(field) >= 0;
        },
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
    },
};
