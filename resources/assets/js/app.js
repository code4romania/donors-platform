import { InertiaApp } from '@inertiajs/inertia-vue';
import languageBundle from '~/lang/index.js';

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import VueMeta from 'vue-meta';
import VuePortal from 'portal-vue';
import VueSvg from 'svg-vue';
import VueClickOutside from 'vue-click-outside';

Vue.config.productionTip = false;

Vue.use(InertiaApp);
Vue.use(VueI18n);
Vue.use(VueMeta);
Vue.use(VuePortal);
Vue.use(VueSvg);

Vue.directive('click-away', VueClickOutside);
Vue.prototype.$route = (...args) => route(...args).url();

const app = document.getElementById('app');

if (app !== null) {
    let initialPage = JSON.parse(app.dataset.page);

    const i18n = new VueI18n({
        locale: initialPage.locale,
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
