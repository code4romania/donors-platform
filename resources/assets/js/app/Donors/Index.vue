<template>
    <layout>
        <template v-slot:title>
            {{ $t('model.donor.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('donors.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="donors"
            :columns="columns"
            route="donors.show"
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
            donors: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.donor.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.donor.singular').toLowerCase(),
                });
            },
        },
    };
</script>
