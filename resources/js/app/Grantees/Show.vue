<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="$userCanOnModel('update', grantee)"
                color="blue"
                :href="$route('grantees.edit', { grantee: grantee.id })"
            >
                {{ editLabel }}
            </form-button>
        </template>

        <panel>
            <div class="max-w-3xl mt-2 mb-5">
                <h2
                    class="text-2xl font-bold leading-tight md:text-3xl"
                    v-text="grantee.name"
                />

                <p class="text-gray-500">
                    <span v-text="$t('field.tax_id')" />:
                    <span v-text="grantee.tax_id" />
                </p>
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
            :collection="projects"
            :columns="columns"
            route-name="grants.show"
            :route-args="routeArgs"
            :route-fill="{ grant: 'grant_id' }"
            :show-row-urls="true"
            :paginate="true"
        >
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
            grantee: Object,
            projects: Object,
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
                return this.grantee.name;
            },
            editLabel() {
                return this.$t('dashboard.action.edit');
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grantee.plural'),
                        href: this.$route('grantees.index'),
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
                routeArgs: { grantee: this.grantee.id },
                cards: [
                    {
                        title: this.$t('field.total_funding'),
                        size: 'lg',
                        number: this.grantee.total_funding,
                    },
                    {
                        title: this.$t('field.donors_count'),
                        size: 'lg',
                        number: this.grantee.donors_count,
                    },
                ],
            };
        },
    };
</script>
