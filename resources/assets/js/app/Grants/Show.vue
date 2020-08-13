<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('grants.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.grant.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ pageTitle }}
        </template>

        <template v-slot:actions>
            <div>
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
                class="mt-2 text-2xl font-bold leading-tight md:text-3xl"
                v-text="grant.name"
            />
        </panel>

        <grid class="md:grid-cols-3">
            <div>
                <grid>
                    <stats-card
                        v-for="(card, index) in cards"
                        :key="index"
                        :title="card.title"
                        :number="card.number"
                    />
                </grid>
            </div>
            <data-table
                class="md:col-span-2"
                :data="grant.grantees"
                :columns="['name', 'domain', 'amount']"
            />
        </grid>
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
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.grant.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.grant.singular').toLowerCase(),
                });
            },
        },
        data() {
            return {
                form: {
                    name: null,
                    type: null,
                    hq: null,
                    contact: null,
                    email: null,
                    phone: null,
                    areas: [],
                },
                cards: [
                    {
                        title: 'Total value of grants',
                        number: this.grant.total_value.formatted,
                    },
                    {
                        title: 'Total number of grantees',
                        number: this.grant.grantees.length,
                    },
                    {
                        title: 'Areas covered',
                        number: this.grant.domain.name || null,
                    },
                ],
            };
        },
    };
</script>
