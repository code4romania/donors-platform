import throttle from 'lodash/throttle';
import pickBy from 'lodash/pickBy';

export default {
    props: {
        filters: Object,
    },
    data() {
        return {
            filter: {
                search: this.filters.search,
            },
        };
    },
    watch: {
        filter: {
            deep: true,
            handler: throttle(function() {
                this.$inertia.replace(
                    this.$route(this.$page.route, pickBy(this.filter))
                );
            }, 200),
        },
    },
};
