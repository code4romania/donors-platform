<template>
    <chart type="bar" height="600" :options="mergedOptions" :series="series" />
</template>

<script>
    import ApexCharts from 'vue-apexcharts';
    import defaultsDeep from 'lodash/defaultsDeep';

    export default {
        name: 'BarChart',
        components: {
            chart: ApexCharts,
        },
        props: {
            id: {
                type: [String, null],
                default: null,
            },
            options: {
                type: Object,
                default: () => ({}),
            },
            series: {
                type: Array,
                default: () => [],
            },
        },
        computed: {
            mergedOptions() {
                let currency = this.options.currency || this.$page.props.currency,
                    categories = this.options.xaxis.categories.join('-');

                return defaultsDeep({}, this.options, {
                    chart: {
                        type: 'bar',
                        id: `${this.id}-${categories}-${currency}`,
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '90%',
                            distributed: false,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        show: true,
                        width: 5,
                        colors: ['transparent'],
                    },
                    yaxis: {
                        labels: {
                            formatter(value) {
                                return (
                                    value.toLocaleString(
                                        document.documentElement.lang
                                    ) +
                                    ' ' +
                                    currency
                                );
                            },
                        },
                    },
                    legend: {
                        fontSize: '14px',
                        fontFamily: `'Titillium Web', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif'`,

                        horizontalAlign: 'left',
                        showForSingleSeries: true,
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8,
                        },

                        onItemClick: {
                            toggleDataSeries: false,
                        },
                    },
                    tooltip: {
                        onDatasetHover: {
                            highlightDataSeries: true,
                        },
                    },
                });
            },
        },
    };
</script>
