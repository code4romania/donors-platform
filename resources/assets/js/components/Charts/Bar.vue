<template>
    <chart type="bar" height="600" :options="mergedOptions" :series="series" />
</template>

<script>
    import ApexCharts from 'vue-apexcharts';
    import defaultsDeep from 'lodash/defaultsDeep';

    function formatNumber(value, currency) {
        return new Intl.NumberFormat(document.documentElement.lang, {
            style: 'currency',
            currency: currency,
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(value);
    }

    export default {
        name: 'BarChart',
        components: {
            chart: ApexCharts,
        },
        props: {
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
                let currency = this.options.currency || this.$page.currency;

                return defaultsDeep({}, this.options, {
                    chart: {
                        type: 'bar',
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
                            formatter: (value) => formatNumber(value, currency),
                        },
                    },
                    legend: {
                        fontSize: '14px',
                        fontFamily: `'Titillium Web', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif'`,

                        horizontalAlign: 'left',
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
