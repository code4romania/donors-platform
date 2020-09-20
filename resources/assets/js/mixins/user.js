export default {
    computed: {
        permissionsByGroup() {
            return Object.keys(this.permissions).map(model => ({
                model: model,
                label: this.$t(`model.${model}.plural`),
                permissions: this.permissions[model].map(action => ({
                    action: action,
                    label: this.$t(`dashboard.permission.${action}`),
                })),
            }));
        },
        translatedRoles() {
            return this.roles.map(role => ({
                value: role,
                label: this.$t(`dashboard.role.${role}`),
            }));
        },
    },
};
