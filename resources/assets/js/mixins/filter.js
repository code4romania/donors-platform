import merge from 'lodash/merge';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';

export default {
    data() {
        return {
            filters: this.$page.props.filters || {},
            search: this.$page.props.search,
            sort: this.$page.props.sort,
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
                this.$route(this.$page.props.route, {
                    remember: 'forget',
                    ...this.routeArgs,
                })
            );
        },
        submit() {
            this.$inertia.replace(
                this.$route(this.$page.props.route, this.routeData)
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
