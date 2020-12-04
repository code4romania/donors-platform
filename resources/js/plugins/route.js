import route from 'ziggy-js';
export default {
    install(Vue) {
        Vue.prototype.$route = (...args) => route(...args);
    },
};
