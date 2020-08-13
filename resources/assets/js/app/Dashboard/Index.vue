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
    export default {
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
    };
</script>
