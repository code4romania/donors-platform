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

        <data-block :table-data="donors.data" :columns="columns">
            <template v-slot:total_funding="{ total_funding }">
                {{ total_funding.formatted }}
            </template>
        </data-block>
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
                columns: [
                    {
                        field: 'name',
                        label: 'Donor',
                        sortable: true,
                    },
                    {
                        field: 'type',
                        label: 'Type',
                        sortable: true,
                    },
                    {
                        field: 'grant_count',
                        label: 'Grants',
                        sortable: true,
                    },
                    {
                        field: 'total_funding',
                        label: 'Total funding',
                        sortable: {
                            prop: 'amount',
                            numeric: true,
                        },
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
