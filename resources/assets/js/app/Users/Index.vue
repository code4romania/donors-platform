<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('users.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="filter.search" />

        <model-table
            :collection="users"
            :columns="columns"
            route="users.edit"
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
            users: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.user.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.user.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.user.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
