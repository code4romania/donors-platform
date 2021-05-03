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

        <data-block
            :options="chart.options"
            :series="chart.series"
            id="dashboard"
        >
            <template #filters>
                <chart-filter @reset="reset">
                    <form-select
                        id="years"
                        :placeholder="$t('dashboard.filter.year')"
                        :options="years"
                        :multiple="true"
                        v-model="filters.years"
                    />

                    <form-select
                        id="domains"
                        :placeholder="$t('dashboard.filter.domain')"
                        :options="domains"
                        option-value-key="id"
                        option-label-key="name"
                        :multiple="true"
                        v-model="filters.domains"
                    />
                </chart-filter>
            </template>
        </data-block>
    </layout>
</template>

<script>
    import ChartFilterMixin from '@/mixins/chartFilter';

    export default {
        mixins: [ChartFilterMixin],
        props: {
            chart: Object,
            stats: Object,
            domains: Array,
            donors: Array,
            years: Array,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                filters: this.prepareFilters(['years', 'domains', 'donors'], []),
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
