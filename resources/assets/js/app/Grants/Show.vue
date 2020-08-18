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
            <h2
                class="max-w-3xl mt-2 text-2xl font-bold leading-tight md:text-3xl"
                v-text="grant.name"
            />

            <grid class="mt-8 md:grid-cols-4">
                <stats-card
                    v-for="(card, index) in cards"
                    :key="index"
                    :title="card.title"
                    :number="card.number"
                    :with-panel="false"
                />
            </grid>
        </panel>

        <data-block
            :table-data="grant.projects"
            :columns="columns"
            route-name="projects.edit"
            :route-args="{ grant: grant.id }"
            :route-fill="{ project: 'id' }"
        >
            <template v-slot:grantee="column">
                {{ column.grantee.name }}
            </template>

            <template v-slot:amount="column">
                {{ column.amount.formatted }}
            </template>
        </data-block>
    </layout>
</template>

<script>
    export default {
        props: {
            grant: Object,
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
                cards: [
                    {
                        title: 'Donors',
                        number: Object.values(this.grant.donors).join(', ') || null,
                    },
                    {
                        title: 'Total value of grants',
                        number: this.grant.total_value.formatted || null,
                    },
                    {
                        title: 'Total number of grantees',
                        number: this.grant.grantees || null,
                    },
                    {
                        title: 'Areas covered',
                        number: this.grant.domain.name || null,
                    },
                ],
                columns: [
                    {
                        field: 'grantee',
                        label: 'Grantee',
                        sortable: {
                            prop: 'name',
                        },
                    },
                    {
                        field: 'title',
                        label: 'Title',
                        sortable: true,
                    },
                    {
                        field: 'amount',
                        label: 'Amount',
                        sortable: {
                            prop: 'amount',
                            numeric: true,
                        },
                    },
                    {
                        field: 'start_date',
                        label: 'Start date',
                        sortable: true,
                    },
                    {
                        field: 'end_date',
                        label: 'End date',
                        sortable: true,
                    },
                ],
            };
        },
    };
</script>
