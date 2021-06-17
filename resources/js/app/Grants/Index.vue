<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="$userCan('create', 'grants')"
                color="blue"
                :href="$route('grants.create')"
            >
                {{ createLabel }}
            </form-button>
        </template>

        <search-filter
            v-model="search"
            @reset="reset"
            filter-class="sm:grid-cols-4"
        >
            <form-select
                id="domain"
                :label="$t('model.domain.plural')"
                :options="domains"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.domain"
            />

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

            <form-select
                id="grantee"
                :label="$t('model.grantee.plural')"
                :options="grantees"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.grantee"
            />
        </search-filter>

        <model-table
            :collection="grants"
            :columns="columns"
            route-name="grants.show"
            :paginate="true"
        >
            <template #name="{ name, row }">
                {{ name }}

                <div class="mt-2 text-sm text-gray-500">
                    <p v-if="row.primary_domain">
                        {{ $t('model.domain.primary') }}:
                        {{ row.primary_domain }}
                    </p>

                    <p v-if="row.secondary_domains.length">
                        {{ $t('model.domain.secondary') }}:
                        {{ row.secondary_domains.join(', ') }}
                    </p>
                </div>
            </template>

            <template #donors="{ donors, row }">
                {{ donors.join(', ') }}

                <div
                    class="flex items-center mt-2 text-sm text-gray-500"
                    v-if="row.manager"
                >
                    {{ $t('model.manager.singular') }}:
                    {{ row.manager }}
                </div>
            </template>

            <template #amount="{ amount, row }">
                <div class="text-right" v-text="amount" />

                <div
                    v-if="amount !== row.converted_amount"
                    v-text="row.converted_amount"
                    class="text-sm text-right text-gray-500"
                />
            </template>

            <template #published_status="{ published_status }">
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
            donors: Array,
            domains: Array,
            managers: Array,
            grantees: Array,
        },
        metaInfo() {
            return {
                title: this.$t('model.grant.plural'),
            };
        },
        data() {
            return {
                filters: this.prepareFilters([
                    'domain',
                    'donor',
                    'manager',
                    'grantee',
                ]),
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
