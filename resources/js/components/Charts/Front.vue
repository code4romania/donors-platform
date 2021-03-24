<template>
    <div class="relative space-y-6">
        <template v-if="error"> as</template>
        <template v-else>
            <grid class="sm:grid-cols-3">
                <div class="w-full sm:w-auto">
                    <form-button
                        v-if="hasFilters"
                        type="button"
                        color="red"
                        shade="regular"
                        class="text-sm truncate"
                        @click="reset"
                        v-text="labels.reset"
                    />
                </div>

                <form-select
                    id="years"
                    :placeholder="labels.years"
                    :options="years"
                    :multiple="true"
                    v-model="filters.years"
                />

                <form-select
                    id="domains"
                    :placeholder="labels.domains"
                    :options="domains"
                    option-value-key="id"
                    option-label-key="name"
                    :multiple="true"
                    v-model="filters.domains"
                />
            </grid>
            <div
                v-if="loading"
                class="flex items-center justify-center bg-gray-100 rounded-lg py-80"
            >
                <svg
                    class="w-20 h-20 text-teal-600 fill-current animate-spin"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M18.364 5.636L16.95 7.05A7 7 0 1 0 19 12h2a9 9 0 1 1-2.636-6.364z"
                    />
                </svg>
            </div>

            <div
                v-else
                class="relative px-4 py-5 bg-white rounded shadow sm:p-6"
            >
                <slot name="notice" />

                <bar-chart
                    id="stats"
                    :options="chart.options"
                    :series="chart.series"
                />
            </div>
        </template>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'ChartFront',
        props: {
            dataUrl: {
                type: String,
                required: true,
            },
            labels: {
                type: Object,
                default: () => ({}),
            },
            currencies: {
                type: Array,
                default: () => [],
            },
            domains: {
                type: Array,
                default: () => [],
            },
            years: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                error: false,
                loading: true,
                chart: null,
                filters: {
                    currency: null,
                    years: [],
                    domains: [],
                },
            };
        },
        computed: {
            hasFilters() {
                if (!Object.keys(this.filters).length) {
                    return false;
                }

                return (
                    (this.filters.hasOwnProperty('years') &&
                        this.filters.years.length) ||
                    (this.filters.hasOwnProperty('domains') &&
                        this.filters.domains.length)
                );
            },
        },
        methods: {
            fetchData() {
                this.loading = true;

                let params = {};

                Object.keys(this.filters).forEach((prop) => {
                    if (this.filters[prop] === null || !this.filters[prop].length) {
                        return;
                    }

                    params[prop] = this.filters[prop];
                });

                axios
                    .get(this.dataUrl, { params })
                    .then((res) => {
                        this.chart = res.data;
                    })
                    .catch(() => {
                        this.error = true;
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            reset() {
                this.filters = {
                    currency: null,
                    years: [],
                    domains: [],
                };
                this.fetchData();
            },
        },
        created() {
            this.fetchData();
        },
        watch: {
            filters: {
                deep: true,
                handler() {
                    this.fetchData();
                },
            },
        },
    };
</script>
