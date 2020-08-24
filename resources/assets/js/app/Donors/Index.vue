<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('donors.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="filter.search" />

        <model-table
            :collection="donors"
            :columns="columns"
            route="donors.show"
            :paginate="true"
        >
            <template v-slot:published_status="{ published_status }">
                <published-badge :status="published_status" />
            </template>
        </model-table>
    </layout>
</template>

<script>
    import FilterMixin from '@/mixins/filter';

    export default {
        mixins: [FilterMixin],
        props: {
            columns: Array,
            donors: Object,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        computed: {
            pageTitle() {
                return this.$t('model.donor.plural');
            },
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.donor.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.donor.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
