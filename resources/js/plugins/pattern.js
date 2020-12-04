import Cleave from 'cleave.js';

export default {
    install(Vue) {
        Vue.directive('pattern', {
            bind(input, binding) {
                input._vPattern = new Cleave(input, binding.value);
            },
            unbind(input) {
                input._vPattern.destroy();
            },
        });
    },
};
