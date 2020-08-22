export default {
    watch: {
        donor_count: {
            handler(newValue, oldValue) {
                newValue = this.clamp(newValue, 1, 10);

                if (newValue < oldValue) {
                    this.form.donors.splice(newValue);
                } else {
                    this.form.donors = this.form.donors.concat(
                        Array(newValue - this.form.donors.length).fill(null)
                    );
                }
            },
            immediate: true,
        },
    },
};
