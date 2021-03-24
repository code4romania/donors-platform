import debounce from 'lodash/debounce';

export default {
    data() {
        return {
            filters: this.$page.props.filters || {},
        };
    },
    computed: {
        routeData() {
            return {
                ...this.routeArgs,
                _query: {
                    currency: this.$page.props.currency,
                    filters: this.filters,
                },
            };
        },
    },
    methods: {
        reset() {
            this.$inertia.get(
                this.$route(this.$page.props.route, {
                    remember: 'forget',
                    ...this.routeArgs,
                })
            );
        },
        submit() {
            this.$inertia.get(
                this.$route(this.$page.props.route, this.routeData),
                {},
                {
                    preserveScroll: true,
                }
            );
        },
        prepareFilters(filters, defaultValue = null) {
            return filters.reduce((obj, filter) => {
                if (
                    !this.$page.props.filters ||
                    !this.$page.props.filters.hasOwnProperty(filter)
                ) {
                    obj[filter] = defaultValue;
                } else {
                    obj[filter] = this.$page.props.filters[filter];
                }

                return obj;
            }, {});
        },
    },
    watch: {
        search: {
            handler: debounce(function() {
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
