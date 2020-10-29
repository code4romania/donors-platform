<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="$userCanOnModel('update', domain)"
                color="blue"
                :href="$route('domains.edit', { domain: domain.id })"
            >
                {{ editLabel }}
            </form-button>
        </template>

        <panel>
            <div class="max-w-3xl">
                <h2
                    class="mt-2 mb-5 text-2xl font-bold leading-tight md:text-3xl"
                    v-text="domain.name"
                />
            </div>

            <grid class="mt-8 md:grid-cols-2 xl:grid-cols-4">
                <stats-card
                    v-for="(card, index) in cards"
                    :key="index"
                    :title="card.title"
                    :number="card.number"
                    :with-panel="false"
                />
            </grid>
        </panel>

        <model-table
            :collection="grants"
            :columns="columns"
            route-name="grants.show"
            :route-args="routeArgs"
            :route-fill="{ grant: 'id' }"
            :show-row-urls="false"
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

            <template #amount="{ amount }">
                <div class="text-right" v-text="amount" />
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
            domain: Object,
            grants: Object,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        computed: {
            newGrantLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.grant.singular').toLowerCase(),
                });
            },
            pageTitle() {
                return this.domain.name;
            },
            editLabel() {
                return this.$t('dashboard.action.edit');
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.domain.plural'),
                        href: this.$route('domains.index'),
                    },
                    {
                        label: this.$t('dashboard.action.view'),
                        href: null,
                    },
                ];
            },
        },
        data() {
            return {
                routeArgs: { domain: this.domain.id },
                cards: [
                    {
                        title: this.$t('field.parent_domains'),
                        size: 'lg',
                        number: this.domain.parent_domains || '–',
                    },
                    {
                        title: this.$t('field.total_funding'),
                        size: 'lg',
                        number: this.domain.total_funding,
                    },
                    {
                        title: this.$t('field.donors_count'),
                        size: 'lg',
                        number: this.domain.donors_count,
                    },
                ],
            };
        },
    };
</script>
