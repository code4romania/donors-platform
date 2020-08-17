<template>
    <layout :breadcrumbs="breadcrumbs">
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
                title: this.pageTitle,
            };
        },
        computed: {
            pageTitle() {
                return this.$t('model.domain.plural');
            },
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
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
