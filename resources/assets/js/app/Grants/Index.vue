<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCan('create', 'grants')"
                    color="blue"
                    :href="$route('grants.create')"
                >
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="search" @reset="reset">
            <form-select
                id="domain"
                :label="$t('model.domain.plural')"
                :options="domains.data"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.domain"
            />

            <form-select
                id="donor"
                :label="$t('model.donor.plural')"
                :options="donors.data"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.donor"
            />

            <form-select
                id="manager"
                :label="$t('model.manager.plural')"
                :options="managers.data"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.manager"
            />
        </search-filter>

        <model-table
            :collection="grants"
            :columns="columns"
            route-name="grants.show"
            :paginate="true"
        >
            <template v-slot:name="{ name, row }">
                {{ name }}

                <div
                    v-if="row.domains.length"
                    class="flex items-center mt-2 text-sm text-gray-500"
                    :aria-label="$t('model.domain.plural')"
                    v-text="row.domains.join(', ')"
                />
            </template>

            <template v-slot:donors="{ donors, row }">
                {{ donors.join(', ') }}

                <div
                    class="flex items-center mt-2 text-sm text-gray-500"
                    v-if="row.managers.length"
                >
                    {{ $t('model.manager.singular') }}:
                    {{ row.managers[0] }}
                </div>
            </template>

            <template v-slot:amount="{ amount }">
                <div class="text-right" v-text="amount" />
            </template>

            <template v-slot:published_status="{ published_status }">
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
            donors: Object,
            domains: Object,
            managers: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.grant.plural'),
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
