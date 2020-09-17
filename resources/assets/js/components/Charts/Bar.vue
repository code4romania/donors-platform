<script>
    import defaultsDeep from 'lodash/defaultsDeep';
    import { Bar, mixins } from 'vue-chartjs';

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
        extends: Bar,
        mixins: [mixins.reactiveProp],
        props: {
            width: {
                default: null,
            },
            height: {
                default: null,
            },
            chartOptions: {
                type: Object,
                default: () => ({}),
            },
        },

        computed: {
            theme() {
                let colors = [
                    'red',
                    'green',
                    'indigo',
                    'orange',
                    'teal',
                    'purple',
                    'yellow',
                    'blue',
                    'pink',
                ];

                return [
                    ...colors.map(
                        (color) => this.$theme.colors[color][500] || null
                    ),
                    ...colors.map(
                        (color) => this.$theme.colors[color][300] || null
                    ),
                    ...colors.map(
                        (color) => this.$theme.colors[color][700] || null
                    ),
                ];
            },
            data() {
                let data = this.chartData;

                data.datasets = data.datasets.map((dataset, index) => {
                    dataset.backgroundColor = this.theme[index];

                    return dataset;
                });

                return data;
            },
            options() {
                let defaults = {
                    responsive: true,
                    legend: {
                        display: true,
                        align: 'end',
                    },
                    tooltips: {
                        callbacks: {
                            label(tooltip, data) {
                                let dataset = data.datasets[tooltip.datasetIndex];

                                return (
                                    dataset.label +
                                    ': ' +
                                    formatNumber(tooltip.yLabel, data.currency)
                                );
                            },
                        },
                    },
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    callback(value, index, values) {
                                        return formatNumber(
                                            value,
                                            this.chart.data.currency
                                        );
                                    },
                                },
                            },
                        ],
                    },
                };

                return defaultsDeep({}, this.chartOptions, defaults);
            },
        },
        mounted() {
            this.renderChart(this.data, this.options);
        },
    };
</script>
