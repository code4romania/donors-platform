<template>
    <layout :breadcrumbs="breadcrumbs">
        <template #actions>
            <form-button
                v-if="$userCan('create', 'domains')"
                color="blue"
                :href="$route('domains.create')"
            >
                {{ createLabel }}
            </form-button>
        </template>

        <base-table
            :data="domains"
            :columns="columns"
            route-name="domains.show"
        >
            <template #name="{ name, row }">
                <div :class="indentWithDepth(row)" v-text="name" />
            </template>

            <template #total_funding="{ total_funding }">
                <div class="text-right" v-text="total_funding" />
            </template>
        </base-table>
    </layout>
</template>

<script>
    export default {
        props: {
            columns: Array,
            domains: Array,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        computed: {
            pageTitle() {
                return this.$t('model.domain.plural');
            },
            createLabel() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.domain.plural'),
                        href: null,
                    },
                ];
            },
        },
        methods: {
            indentWithDepth(domain) {
                return ['', 'pl-8', 'pl-16', 'pl-24'][domain.depth];
            },
        },
    };
</script>
