import { InertiaApp } from '@inertiajs/inertia-vue';
import languageBundle from '~/lang/index.js';

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import VueMeta from 'vue-meta';
import VuePortal from 'portal-vue';
import VueSvg from 'svg-vue';
import VueClickOutside from 'vue-click-outside';

import ComponentsPlugin from '@/plugins/components';
import PermissionsPlugin from '@/plugins/permissions';
import RoutePlugin from '@/plugins/route';

Vue.config.productionTip = false;

Vue.use(InertiaApp);
Vue.use(VueI18n);
Vue.use(VueMeta);
Vue.use(VuePortal);
Vue.use(VueSvg);
Vue.use(ComponentsPlugin);
Vue.use(PermissionsPlugin);
Vue.use(RoutePlugin);

Vue.directive('click-away', VueClickOutside);

const app = document.getElementById('app');

if (app !== null) {
    let initialPage = JSON.parse(app.dataset.page);

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
        render: h => h(InertiaApp, {
            props: {
                initialPage,
                resolveComponent: name => require(`@/${name}`).default,
            },
        }),
        i18n,
    }).$mount(app);
}
