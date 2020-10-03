export default {
    install(Vue) {
        Vue.prototype.$userCan = function(action, model, permissions) {
            if (
                !this.$page.auth.permissions.hasOwnProperty(model) ||
                !this.$page.auth.permissions[model].hasOwnProperty(action)
            ) {
                return false;
            }

            return this.$page.auth.permissions[model][action];
        };

        Vue.prototype.$userCanOnModel = function(action, model) {
            if (this.$userHasRole('admin')) {
                return true;
            }

            if (
                !model.hasOwnProperty('can') ||
                !model.can.hasOwnProperty(action)
            ) {
                return false;
            }

            return model.can[action];
        };

        Vue.prototype.$userHasRole = function(role) {
            return this.$page.auth.role === role;
        };
    },
};
