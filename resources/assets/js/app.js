import { app, plugin } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress';

import languageBundle from '~/lang/index.js';

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import VueMeta from 'vue-meta';
import VuePortal from 'portal-vue';
import VueSvg from 'svg-vue';
import VueClickOutside from 'vue-click-outside';

import ThemePlugin from '@/plugins/theme';
import ComponentsPlugin from '@/plugins/components';
import PermissionsPlugin from '@/plugins/permissions';
import RoutePlugin from '@/plugins/route';
import PatternPlugin from '@/plugins/pattern';

Vue.config.productionTip = false;

Vue.use(plugin);
Vue.use(VueI18n);
Vue.use(VueMeta);
Vue.use(VuePortal);
Vue.use(VueSvg);
Vue.use(ThemePlugin);
Vue.use(ComponentsPlugin);
Vue.use(PermissionsPlugin);
Vue.use(RoutePlugin);
Vue.use(PatternPlugin);

Vue.directive('click-away', VueClickOutside);

InertiaProgress.init({
    // The delay after which the progress bar will
    // appear during navigation, in milliseconds.
    delay: 250,

    // The color of the progress bar.
    color: '#3F83F8',

    // Whether to include the default NProgress styles.
    includeCSS: true,

    // Whether the NProgress spinner will be shown.
    showSpinner: false,
});

const el = document.getElementById('app');

let initialPage = JSON.parse(el.dataset.page);

const i18n = new VueI18n({
    locale: initialPage.props.locale,
    messages: languageBundle,
});

new Vue({
    metaInfo: {
        // prettier-ignore
        titleTemplate: title => (title ? `${title} - ` : '') + 'Donors Platform'
    },
    // prettier-ignore
    render: h => h(app, {
            props: {
                initialPage,
                resolveComponent: name => require(`@/app/${name}`).default,
            },
        }),
    i18n,
}).$mount(el);
