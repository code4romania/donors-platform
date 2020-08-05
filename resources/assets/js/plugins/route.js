export default {
    install(Vue) {
        Vue.prototype.$route = (...args) => route(...args).url();
    },
};
