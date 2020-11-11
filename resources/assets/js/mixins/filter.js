import merge from 'lodash/merge';
import pickBy from 'lodash/pickBy';
import throttle from 'lodash/throttle';
import isEmpty from 'lodash/isEmpty';

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
            let data = pickBy(
                merge({ search: this.search }, this.sort, this.routeArgs)
            );

            let filters = pickBy(this.filters);

            if (!isEmpty(filters)) {
                data.filters = filters;
            }

            return !isEmpty(data) ? data : { remember: 'forget' };
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
