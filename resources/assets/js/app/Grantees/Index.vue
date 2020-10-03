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

        <search-filter
            v-model="search"
            @reset="reset"
            filter-class="sm:grid-cols-2"
        >
            <form-select
                id="donor"
                :label="$t('model.donor.plural')"
                :options="donors"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.donor"
            />

            <form-select
                id="manager"
                :label="$t('model.manager.plural')"
                :options="managers"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.manager"
            />
        </search-filter>

        <model-table
            :collection="grantees"
            :columns="columns"
            route-name="grantees.show"
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
            donors: Array,
            managers: Array,
        },
        metaInfo() {
            return {
                title: this.$t('model.grantee.plural'),
            };
        },
        data() {
            return {
                filters: this.prepareFilters(['donor', 'manager']),
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
