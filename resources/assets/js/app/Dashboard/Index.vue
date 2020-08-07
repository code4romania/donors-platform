<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.menu.dashboard') }}
        </template>

        <grid class="md:grid-cols-3">
            <stats-card
                v-for="(card, index) in cards"
                :key="index"
                :title="card.title"
                :number="card.number"
            />
        </grid>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout/Default';
    import Grid from '@/Shared/Grid';
    import StatsCard from '@/Shared/Stats/Card';

    export default {
        components: {
            Layout,
            Grid,
            StatsCard,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.menu.dashboard'),
            };
        },
        props: {
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
                            areas: this.stats.focusAreas,
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
    };
</script>
