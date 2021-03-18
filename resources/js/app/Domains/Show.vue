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
                    :class="card.class || false"
                    :size="card.size"
                    :with-panel="false"
                />

                <aside
                    class="leading-tight md:col-span-2 xl:col-span-4"
                    v-if="domain.subdomains.length"
                >
                    <div
                        class="mb-1 text-sm text-gray-500"
                        v-text="$t('field.included_subdomains')"
                    />

                    <details class="text-base text-gray-900 font-">
                        <summary
                            class="inline-block text-2xl font-semibold text-blue-500 cursor-pointer focus:outline-none hover:text-blue-600"
                            v-text="
                                $tc(
                                    'model.domain.count',
                                    domain.subdomains.length
                                )
                            "
                        />

                        <ul
                            class="block"
                            :class="{
                                'sm:col-count-2 lg:col-count-3 xl:col-count-3':
                                    domain.subdomains.length > 10,
                            }"
                        >
                            <li
                                class="block"
                                v-for="subdomain in domain.subdomains"
                                :class="
                                    [
                                        'mt-4 font-semibold',
                                        'mt-0.5 pl-6',
                                        'mt-0.5 pl-12',
                                        'mt-0.5 pl-18',
                                    ][subdomain.depth - 1]
                                "
                                :key="subdomain.id"
                            >
                                <inertia-link
                                    :href="$route('domains.show', subdomain.id)"
                                    class="focus:outline-none focus:text-blue-500 hover:text-blue-600"
                                    v-text="subdomain.name"
                                />
                            </li>
                        </ul>
                    </details>
                </aside>
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
                        title: this.$t('field.total_funding'),
                        size: 'lg',
                        number: this.domain.total_funding,
                    },
                    {
                        title: this.$t('field.donors_count'),
                        size: 'lg',
                        number: this.domain.donors_count,
                    },
                    {
                        title: this.$t('field.grants_count'),
                        size: 'lg',
                        number: this.domain.grants_count,
                    },
                    {
                        title: this.$t('field.projects_count'),
                        size: 'lg',
                        number: this.domain.projects_count,
                    },
                ],
            };
        },
    };
</script>
