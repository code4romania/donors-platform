<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCan('create', 'grantees')"
                    color="blue"
                    :href="$route('grantees.create')"
                >
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="search" @reset="reset" />

        <model-table
            :collection="grantees"
            :columns="columns"
            route-name="grantees.edit"
            :show-row-urls="$userCan('create', 'grantees')"
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
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grantee.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
