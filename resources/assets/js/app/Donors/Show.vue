<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    color="blue"
                    :href="$route('donors.edit', { donor: donor.id })"
                >
                    {{ editLabel }}
                </form-button>
            </div>
        </template>

        <panel>
            <div
                class="grid gap-4 sm:grid-cols-3 md:gap-x-6 md:gap-y-8 md:grid-cols-5"
            >
                <div class="md:row-span-2">
                    <div class="relative border aspect-ratio-1/1">
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <img class="w-full" :src="donor.logo" alt="" />
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 md:col-span-4">
                    <published-badge :status="donor.published_status" />

                    <h2
                        class="mt-2 text-2xl font-bold leading-tight md:text-3xl"
                        v-text="donor.name"
                    />

                    <div v-if="donor.hq" class="flex items-center">
                        <svg-vue
                            icon="Map/map-pin-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <span v-text="donor.hq" />
                    </div>
                </div>

                <div class="sm:col-span-3 md:col-span-2">
                    <strong class="text-lg" v-text="donor.contact" />

                    <div v-if="donor.email" class="flex items-center mt-1">
                        <svg-vue
                            icon="Business/at-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`mailto:${donor.email}`"
                            class="hover:underline"
                            v-text="donor.email"
                        />
                    </div>

                    <div v-if="donor.phone" class="flex items-center mt-1">
                        <svg-vue
                            icon="Device/phone-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`tel:${donor.phone}`"
                            class="hover:underline"
                            v-text="donor.phone"
                        />
                    </div>
                </div>

                <div
                    class="sm:col-span-3 md:col-span-2"
                    v-if="donor.domains.length"
                >
                    <strong class="text-lg" v-text="$t('field.domains')" />
                    <div class="flex mt-1">
                        <svg-vue
                            icon="Design/focus-3-line"
                            class="flex-shrink-0 w-4 h-6 mr-1 text-gray-500 fill-current"
                        />
                        <div
                            v-html="
                                donor.domains
                                    .map((domain) => domain.name)
                                    .join(', ')
                            "
                        />
                    </div>
                </div>
            </div>
        </panel>

        <panel>
            <grid class="lg:grid-cols-3">
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

        <search-filter v-model="search" @reset="reset">
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

        <data-block>
            <template slot="table">
                <model-table
                    :collection="grants"
                    :columns="columns"
                    route-name="grants.show"
                    :sort-args="routeArgs"
                    :route-fill="{ grant: 'id' }"
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

                    <template v-slot:amount="{ amount }">
                        <div class="text-right" v-text="amount" />
                    </template>

                    <template v-slot:published_status="{ published_status }">
                        <published-badge :status="published_status" />
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
            donor: Object,
            domains: Object,
            grants: Object,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        computed: {
            pageTitle() {
                return this.donor.name;
            },
            editLabel() {
                return this.$t('dashboard.action.edit');
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.donor.plural'),
                        href: this.$route('donors.index'),
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
                routeArgs: { donor: this.donor.id },
                cards: [
                    {
                        title: this.$t('dashboard.stats.total.grants'),
                        size: 'lg',
                        number: this.donor.total_funding,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grantees'),
                        size: 'lg',
                        number: this.donor.grantee_count,
                    },
                    {
                        title: this.$t('dashboard.stats.total.domains'),
                        size: 'sm',
                        number: this.donor.grant_domains
                            .map((domain) => domain.name)
                            .join(', '),
                    },
                ],
            };
        },
    };
</script>
