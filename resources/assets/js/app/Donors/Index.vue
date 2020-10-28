<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="$userCan('create', 'donors')"
                color="blue"
                :href="$route('donors.create')"
            >
                {{ createLabel }}
            </form-button>
        </template>

        <search-filter
            v-model="search"
            @reset="reset"
            filter-class="sm:grid-cols-3"
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
                id="orgtype"
                :label="$t('field.type')"
                :options="types"
                :option-placeholder="$t('dashboard.all')"
                v-model="filters.orgtype"
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
            :collection="donors"
            :columns="columns"
            route-name="donors.show"
            :paginate="true"
        >
            <template #name="{ name, row }">
                {{ name }}

                <div
                    v-if="row.domains.length"
                    class="flex items-center mt-2 text-sm text-gray-500"
                    :aria-label="$t('model.domain.plural')"
                    v-text="row.domains.join(', ')"
                />
            </template>

            <template #type="{ type }">
                {{ $t(`dashboard.org_type.${type}`) }}
            </template>

            <template #total_funding="{ total_funding }">
                <div class="text-right" v-text="total_funding" />
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
            donors: Object,
            domains: Array,
            managers: Array,
            types: Array,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                filters: this.prepareFilters(['domain', 'orgtype', 'manager']),
            };
        },
        computed: {
            pageTitle() {
                return this.$t('model.donor.plural');
            },
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.donor.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.donor.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
