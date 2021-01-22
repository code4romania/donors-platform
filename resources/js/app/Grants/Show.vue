<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="
                    $userCanOnModel('update', grant) && grant.project_slots > 0
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
            <published-badge :status="grant.published_status" />

            <h2
                class="mt-2 mb-5 text-2xl font-bold leading-tight md:text-3xl"
                v-text="grant.name"
            />

            <grid class="md:grid-cols-2 md:gap-12">
                <dl class="space-y-3">
                    <div v-if="grant.primary_domain">
                        <dt
                            class="font-bold text-gray-900"
                            v-text="$t('model.domain.primary')"
                        />

                        <dd v-text="grant.primary_domain" />
                    </div>

                    <div v-if="grant.secondary_domains.length">
                        <dt
                            class="font-bold text-gray-900"
                            v-text="$t('model.domain.secondary')"
                        />

                        <dd v-text="grant.secondary_domains.join(', ')" />
                    </div>

                    <div>
                        <dt
                            class="font-bold text-gray-900"
                            v-text="$t('field.description')"
                        />

                        <dd v-text="grant.description" />
                    </div>
                </dl>

                <table class="prose max-w-none">
                    <thead>
                        <tr>
                            <th
                                class="text-left"
                                v-text="$t('model.donor.plural')"
                            />
                            <th
                                class="text-right"
                                v-text="$t('field.contribution')"
                            />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(donor, index) in grant.donors" :key="index">
                            <td v-text="donor.name" />
                            <td v-text="donor.amount" class="text-right" />
                        </tr>
                    </tbody>
                </table>
            </grid>
        </panel>
        <panel>
            <grid class="md:grid-cols-2 xl:grid-cols-4">
                <template v-for="(card, index) in cards">
                    <stats-card
                        v-if="card.visible"
                        :key="index"
                        :title="card.title"
                        :number="card.number"
                        :with-panel="false"
                        :size="card.size"
                    />
                </template>
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
                        visible: true,
                    },
                    {
                        title: this.$t('dashboard.stats.total.regranting'),
                        number: this.grant.regranting_amount,
                        visible: this.grant.regranting_amount !== null,
                    },
                    {
                        title: this.$t('dashboard.stats.total.operational'),
                        number: this.grant.operational_costs,
                        visible: this.grant.operational_costs !== null,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grantees'),
                        number: this.grant.project_count,
                        visible: true,
                    },
                    {
                        title: this.$t('dashboard.stats.total.remaining'),
                        number: this.grant.remaining_amount,
                        visible: this.$userHasRole('admin'),
                    },
                ],
            };
        },
    };
</script>
