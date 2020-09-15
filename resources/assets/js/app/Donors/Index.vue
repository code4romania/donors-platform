<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('donors.create')">
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
                id="orgtype"
                :label="$t('field.type')"
                :options="types"
                :option-placeholder="$t('dashboard.all')"
                v-model="filters.orgtype"
            />
        </search-filter>

        <model-table
            :collection="donors"
            :columns="columns"
            route-name="donors.show"
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

            <template v-slot:type="{ type }">
                {{ $t(`dashboard.org_types.${type}`) }}
            </template>

            <template v-slot:total_funding="{ total_funding }">
                <div class="text-right" v-text="total_funding" />
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
            donors: Object,
            domains: Object,
            types: Array,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
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
