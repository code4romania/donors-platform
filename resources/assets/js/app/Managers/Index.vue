<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCan('create', 'managers')"
                    color="blue"
                    :href="$route('managers.create')"
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
                id="domain"
                :label="$t('model.domain.plural')"
                :options="domains.data"
                :option-placeholder="$t('dashboard.all')"
                option-value-key="id"
                option-label-key="name"
                v-model="filters.domain"
            />
        </search-filter>

        <model-table
            :collection="managers"
            :columns="columns"
            route-name="managers.show"
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
            domains: Object,
            managers: Object,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                filters: this.prepareFilters(['domain']),
            };
        },
        computed: {
            pageTitle() {
                return this.$t('model.manager.plural');
            },
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.manager.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.manager.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
