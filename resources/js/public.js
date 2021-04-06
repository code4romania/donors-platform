import Vue from 'vue';

import ComponentsPlugin from '@/plugins/components';
import VueClickOutside from 'vue-click-outside';

Vue.use(ComponentsPlugin);

Vue.directive('click-away', VueClickOutside);

const el = document.getElementById('app');

if (el) {
    new Vue({
        data: {
            menuOpen: false,
        },
        methods: {
            hideMenu() {
                this.menuOpen = false;
            },
            showMenu() {
                this.menuOpen = true;
            },
            toggleMenu() {
                this.menuOpen = !this.menuOpen;
            },
        },
    }).$mount(el);
}
