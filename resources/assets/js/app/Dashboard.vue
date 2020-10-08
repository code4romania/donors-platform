<template>
    <layout :breadcrumbs="breadcrumbs" currency-select>
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
                    <form-select-multiple
                        id="years"
                        :placeholder="$t('dashboard.filter.year')"
                        :options="years"
                        :show-count="true"
                        v-model="filters.years"
                    />

                    <form-select-multiple
                        id="domains"
                        :placeholder="$t('dashboard.filter.domain')"
                        :options="domains"
                        option-value-key="id"
                        option-label-key="name"
                        :show-count="true"
                        v-model="filters.domains"
                    />

                    <!-- <form-select-multiple
                        id="donors"
                        :label="$t('dashboard.filter.donor')"
                        :options="donors"
                        option-value-key="id"
                        option-label-key="name"
                        v-model="filters.donors"
                    /> -->
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
