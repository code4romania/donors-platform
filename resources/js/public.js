import Vue from 'vue';

import ComponentsPlugin from '@/plugins/components';
Vue.use(ComponentsPlugin);

const el = document.getElementById('chart');

if (el) {
    new Vue().$mount(el);
}
