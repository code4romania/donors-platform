<script>
    import { Bar, mixins } from 'vue-chartjs';

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
        },
        mounted() {
            this.renderChart(this.data, this.options);
        },
    };
</script>
