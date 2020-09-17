<template>
    <layout :breadcrumbs="breadcrumbs">
        <grid class="md:grid-cols-3">
            <stats-card
                v-for="(card, index) in cards"
                :key="index"
                :title="card.title"
                :number="card.number"
            />
        </grid>

        <data-block :chart-data="chart" :chart-options="chartOptions" />
    </layout>
</template>

<script>
    export default {
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        props: {
            chart: Object,
            donors: Object,
            stats: Object,
        },
        data() {
            return {
                cards: [
                    {
                        title: this.$t('dashboard.stats.donors'),
                        number: this.stats.donors,
                    },
                    {
                        title: this.$t('dashboard.stats.funding', {
                            count: this.stats.domains,
                        }),
                        number: this.stats.funding,
                    },
                    {
                        title: this.$t('dashboard.stats.grantees'),
                        number: this.stats.grantees,
                    },
                ],
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.menu.dashboard');
            },
            breadcrumbs() {
                return [
                    {
                        label: this.pageTitle,
                        href: null,
                    },
                ];
            },
            chartOptions() {
                return {
                    scales: {
                        xAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: this.$t('field.year'),
                                },
                            },
                        ],
                        yAxes: [
                            {
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: this.$t('field.amount'),
                                },
                                ticks: {},
                            },
                        ],
                    },
                };
            },
        },
    };
</script>
