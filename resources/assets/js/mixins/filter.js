import mapValues from 'lodash/mapValues';
import merge from 'lodash/merge';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';

export default {
    data() {
        return {
            filters: this.$page.filters,
            search: this.$page.search,
            sort: this.$page.sort,
        };
    },
    computed: {
        routeData() {
            return pickBy(
                merge(
                    {},
                    this.filters,
                    this.sort,
                    { search: this.search },
                    this.routeArgs
                )
            );
        },
    },
    methods: {
        reset() {
            this.filters = mapValues(this.filters, () => null);
            this.search = null;
            this.sort = mapValues(this.sort, () => null);
        },
        submit() {
            this.$inertia.replace(
                this.$route(this.$page.route, this.routeData)
            );
        },
    },
    watch: {
        search: {
            handler: throttle(function() {
                this.submit();
            }, 250),
        },
        sort: {
            deep: true,
            handler: function() {
                this.submit();
            },
        },
        filters: {
            deep: true,
            handler: function() {
                this.submit();
            },
        },
    },
};
