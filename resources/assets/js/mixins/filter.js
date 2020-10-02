import mapValues from 'lodash/mapValues';
import merge from 'lodash/merge';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';

export default {
    data() {
        return {
            filters: this.$page.filters || {},
            search: this.$page.search,
            sort: this.$page.sort,
        };
    },
    computed: {
        routeData() {
            return pickBy(
                merge(
                    {},
                    { filters: this.filters },
                    this.sort,
                    { search: this.search },
                    this.routeArgs
                )
            );
        },
    },
    methods: {
        reset() {
            this.$inertia.replace(
                this.$route(this.$page.route, {
                    remember: 'forget',
                    ...this.routeArgs,
                })
            );
        },
        submit() {
            this.$inertia.replace(
                this.$route(this.$page.route, this.routeData)
            );
        },
        prepareFilters(filters) {
            return filters.reduce((obj, filter) => {
                if (
                    !this.$page.filters ||
                    !this.$page.filters.hasOwnProperty(filter)
                ) {
                    obj[filter] = null;
                } else {
                    obj[filter] = this.$page.filters[filter];
                }

                return obj;
            }, {});
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
