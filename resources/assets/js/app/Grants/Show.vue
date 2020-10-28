<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="
                    $userCanOnModel('update', grant) &&
                    grant.project_count > projects.meta.total
                "
                color="blue"
                shade="light"
                :href="$route('projects.create', { grant: grant.id })"
            >
                {{ newProjectLabel }}
            </form-button>

            <form-button
                v-if="$userCanOnModel('update', grant)"
                color="blue"
                :href="$route('grants.edit', { grant: grant.id })"
            >
                {{ submitLabel }}
            </form-button>
        </template>

        <panel>
            <div class="max-w-3xl">
                <published-badge :status="grant.published_status" />

                <h2
                    class="mt-2 mb-5 text-2xl font-bold leading-tight md:text-3xl"
                    v-text="grant.name"
                />

                <p class="max-w-md" v-text="grant.description" />
            </div>

            <grid class="mt-8 md:grid-cols-2 xl:grid-cols-4">
                <stats-card
                    v-for="(card, index) in cards"
                    :key="index"
                    :title="card.title"
                    :number="card.number"
                    :with-panel="false"
                    :size="card.size"
                />
            </grid>
        </panel>

        <search-filter v-model="search" @reset="reset" />

        <model-table
            :collection="projects"
            :columns="columns"
            route-name="projects.edit"
            :route-args="routeArgs"
            :route-fill="{ project: 'id' }"
            :show-row-urls="$userCanOnModel('update', grant)"
            :paginate="true"
        >
            <template #grantees="{ row }">
                {{ row.grantees.join(', ') }}
            </template>

            <template #amount="{ amount }">
                <div class="text-right" v-text="amount" />
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
                        title: this.$t('dashboard.stats.total.grant'),
                        number: this.grant.amount,
                    },
                    {
                        title: this.$t('dashboard.stats.total.regranting'),
                        number: this.grant.regranting_amount,
                    },
                    {
                        title: this.$t('dashboard.stats.total.operational'),
                        number: this.grant.operational_costs,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grantees'),
                        number: this.grant.project_count,
                    },
                    {
                        title: this.$t('model.donor.plural'),
                        number: Object.values(this.grant.donors).join(', ') || null,
                    },

                    {
                        title: this.$t('model.domain.primary'),
                        number: this.grant.primary_domain || '–',
                    },
                    {
                        title: this.$t('model.domain.secondary'),
                        number: this.grant.secondary_domains.join(', '),
                    },
                ],
            };
        },
    };
</script>
