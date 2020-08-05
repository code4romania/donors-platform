export default {
    install(Vue) {
        Vue.prototype.$userCan = function(ability) {
            return this.$page.auth.user.permissions.includes(ability);
        };
    },
};
