export default {
    computed: {
        organizationLabel() {
            if (this.form.role === 'donor') {
                return this.$t('model.donor.singular');
            }

            if (this.form.role === 'manager') {
                return this.$t('model.manager.singular');
            }

            return null;
        },
        organizationsForRole() {
            if (this.form.role === 'donor') {
                return this.donors;
            }

            if (this.form.role === 'manager') {
                return this.managers;
            }

            return [];
        },
    },
    watch: {
        'form.role': function(newValue) {
            this.form.organization_id = null;
        },
    },
};
