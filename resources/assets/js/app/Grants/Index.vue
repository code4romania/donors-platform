<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('grants.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="grants"
            :columns="columns"
            route="grants.show"
            :paginate="true"
        >
            <template v-slot:published_status="column">
                <published-badge :status="column.published_status" />
            </template>
        </model-table>
    </layout>
</template>

<script>
    export default {
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
