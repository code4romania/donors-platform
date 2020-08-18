<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:title>
            {{ $t('model.grantee.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('grantees.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="grantees"
            :columns="columns"
            route="grantees.edit"
            :paginate="true"
        />
    </layout>
</template>
<script>
    export default {
        props: {
            columns: Array,
            grantees: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.grantee.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.grantee.singular').toLowerCase(),
                });
            },
        },
    };
</script>
