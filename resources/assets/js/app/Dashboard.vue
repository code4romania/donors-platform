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

        <data-block :chart-data="chart" />
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
        },
    };
</script>
