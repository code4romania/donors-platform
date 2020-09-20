<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCanOnModel('update', manager)"
                    color="blue"
                    :href="$route('managers.edit', { manager: manager.id })"
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
                            <img class="w-full" :src="manager.logo" alt="" />
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 md:col-span-4">
                    <published-badge :status="manager.published_status" />

                    <h2
                        class="mt-2 text-2xl font-bold leading-tight md:text-3xl"
                        v-text="manager.name"
                    />

                    <div v-if="manager.hq" class="flex items-center">
                        <svg-vue
                            icon="Map/map-pin-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <span v-text="manager.hq" />
                    </div>
                </div>

                <div class="sm:col-span-3 md:col-span-2">
                    <strong class="text-lg" v-text="manager.contact" />

                    <div v-if="manager.email" class="flex items-center mt-1">
                        <svg-vue
                            icon="Business/at-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`mailto:${manager.email}`"
                            class="hover:underline"
                            v-text="manager.email"
                        />
                    </div>

                    <div v-if="manager.phone" class="flex items-center mt-1">
                        <svg-vue
                            icon="Device/phone-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`tel:${manager.phone}`"
                            class="hover:underline"
                            v-text="manager.phone"
                        />
                    </div>
                </div>

                <div
                    class="sm:col-span-3 md:col-span-2"
                    v-if="manager.domains.length"
                >
                    <strong class="text-lg" v-text="$t('field.domains')" />
                    <div class="flex mt-1">
                        <svg-vue
                            icon="Design/focus-3-line"
                            class="flex-shrink-0 w-4 h-6 mr-1 text-gray-500 fill-current"
                        />
                        <div
                            v-html="
                                manager.domains
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

        <model-table
            :collection="grants"
            :columns="columns"
            route-name="grants.show"
            :route-args="routeArgs"
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

            <template v-slot:regranting_amount="{ regranting_amount }">
                <div class="text-right" v-text="regranting_amount" />
            </template>

            <template v-slot:published_status="{ published_status }">
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
            manager: Object,
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
                return this.manager.name;
            },
            editLabel() {
                return this.$t('dashboard.action.edit');
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.manager.plural'),
                        href: this.$route('managers.index'),
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
                routeArgs: { manager: this.manager.id },
                cards: [
                    {
                        title: this.$t('dashboard.stats.total.grants'),
                        size: 'lg',
                        number: this.manager.total_funding,
                    },
                    {
                        title: this.$t('dashboard.stats.total.grantees'),
                        size: 'lg',
                        number: this.manager.grantee_count,
                    },
                    {
                        title: this.$t('dashboard.stats.total.domains'),
                        size: 'sm',
                        number: this.manager.grant_domains
                            .map((domain) => domain.name)
                            .join(', '),
                    },
                ],
            };
        },
    };
</script>
