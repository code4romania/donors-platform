export default {
    watch: {
        grantee_count: {
            handler(newValue, oldValue) {
                newValue = this.clamp(newValue, 1, 10);

                if (newValue < oldValue) {
                    this.form.grantees.splice(newValue);
                } else {
                    this.form.grantees = this.form.grantees.concat(
                        Array(newValue - this.form.grantees.length).fill(null)
                    );
                }
            },
            immediate: true,
        },
    },
};
