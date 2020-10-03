<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCan('create', 'domains')"
                    color="blue"
                    :href="$route('domains.create')"
                >
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="search" @reset="reset" />

        <model-table
            :collection="domains"
            :columns="columns"
            route-name="domains.edit"
            :show-row-urls="$userCan('create', 'domains')"
            :paginate="true"
        />
    </layout>
</template>

<script>
    import FilterMixin from '@/mixins/filter';

    export default {
        mixins: [FilterMixin],
        props: {
            columns: Array,
            domains: Array,
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
                        label: this.$t('model.domain.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
