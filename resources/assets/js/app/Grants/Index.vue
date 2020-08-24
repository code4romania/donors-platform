<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('grants.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="filter.search" />

        <model-table
            :collection="grants"
            :columns="columns"
            route="grants.show"
            :paginate="true"
        >
            <template v-slot:domains="{ domains }">
                {{ domains.map((domain) => domain.name).join(', ') }}
            </template>

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
            grants: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.grant.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.grant.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grant.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
