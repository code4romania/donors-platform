import merge from 'lodash/merge';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';

export default {
    data() {
        return {
            filters: this.$page.filters || {},
        };
    },
    computed: {
        routeData() {
            return pickBy(
                merge(
                    //
                    { currency: this.$page.currency },
                    { filters: this.filters },
                    this.routeArgs
                )
            );
        },
    },
    methods: {
        reset() {
            this.$inertia.get(
                this.$route(this.$page.route, {
                    remember: 'forget',
                    ...this.routeArgs,
                })
            );
        },
        submit() {
            this.$inertia.get(
                this.$route(this.$page.route, this.routeData),
                {},
                {
                    preserveScroll: true,
                }
            );
        },
        prepareFilters(filters, defaultValue = null) {
            return filters.reduce((obj, filter) => {
                if (
                    !this.$page.filters ||
                    !this.$page.filters.hasOwnProperty(filter)
                ) {
                    obj[filter] = defaultValue;
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
