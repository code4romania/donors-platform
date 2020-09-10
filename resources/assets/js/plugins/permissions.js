export default {
    install(Vue) {
        Vue.prototype.$userCan = function(action, model) {
            if (
                !this.$page.auth.permissions.hasOwnProperty(model) ||
                !this.$page.auth.permissions[model].hasOwnProperty(action)
            ) {
                return false;
            }

            return this.$page.auth.permissions[model][action];
        };
    },
};
