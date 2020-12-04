import resolveConfig from 'tailwindcss/resolveConfig';
import tailwindConfig from '~/../tailwind.config.js';
export default {
    install(Vue) {
        Vue.prototype.$theme = resolveConfig(tailwindConfig).theme || {};
    },
};
