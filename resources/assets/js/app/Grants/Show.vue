<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    color="teal"
                    :href="$route('projects.create', { grant: grant.id })"
                >
                    {{ newProjectLabel }}
                </form-button>

                <form-button
                    color="blue"
                    :href="$route('grants.edit', { grant: grant.id })"
                >
                    {{ submitLabel }}
                </form-button>
            </div>
        </template>

        <panel>
            <published-badge :status="grant.published_status" />
            <h2
                class="max-w-3xl mt-2 text-2xl font-bold leading-tight md:text-3xl"
                v-text="grant.name"
            />

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

        <search-filter v-model="search" @reset="reset" />

        <data-block :table-data="projects.data" :columns="columns">
            <template slot="table">
                <model-table
                    :collection="projects"
                    :columns="columns"
                    route-name="projects.edit"
                    :route-args="routeArgs"
                    :route-fill="{ project: 'id' }"
                    :paginate="true"
                >
                    <template v-slot:grantee___name="{ row }">
                        {{ row.grantee.name }}
                    </template>

                    <template v-slot:amount="{ amount }">
                        {{ amount.formatted }}
                    </template>
                </model-table>
            </template>
        </data-block>
    </layout>
</template>

<script>
    import FilterMixin from '@/mixins/filter';

    export default {
        mixins: [FilterMixin],
        props: {
            columns: Array,
            grant: Object,
            projects: Object,
        },
        metaInfo() {
            return {
                title: this.grant.name,
            };
        },
        computed: {
            submitLabel() {
                return this.$t('dashboard.action.editModel', {
                    model: this.$t('model.grant.singular').toLowerCase(),
                });
            },
            newProjectLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.project.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grant.plural'),
                        href: this.$route('grants.index'),
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
                routeArgs: { grant: this.grant.id },
                cards: [
                    {
                        title: this.$t('model.donor.plural'),
                        number: Object.values(this.grant.donors).join(', ') || null,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grants'),
                        number:
                            this.grant.funding_value !== null
                                ? this.grant.funding_value.formatted
                                : null,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grantees'),
                        number: this.grant.grantees || null,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grants'),
                        number:
                            this.grant.domains
                                .map((domain) => domain.name)
                                .join(', ') || null,
                    },
                ],
            };
        },
    };
</script>
