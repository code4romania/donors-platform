<template>
    <layout>
        <template v-slot:title>
            {{ $t('model.domain.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('domains.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="domains"
            :columns="columns"
            route="domains.edit"
            :paginate="true"
        />
    </layout>
</template>
<script>
    export default {
        props: {
            columns: Array,
            domains: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.domain.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
        },
    };
</script>
