<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('donors.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.donor.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ pageTitle }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button
                    color="blue"
                    :href="$route('donors.edit', { donor: donor.data.id })"
                >
                    {{ submitLabel }}
                </form-button>
            </div>
        </template>

        <panel>
            <div
                class="grid gap-4 sm:grid-cols-3 md:col-gap-6 md:row-gap-8 md:grid-cols-5"
            >
                <div class="md:row-span-2">
                    <div class="relative border aspect-ratio-1/1">
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <img
                                class="w-full"
                                :src="donor.data.logo_url"
                                alt=""
                            />
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 md:col-span-4">
                    <published-badge :status="donor.data.published_status" />

                    <h2
                        class="mt-2 text-2xl font-bold leading-tight md:text-3xl"
                        v-text="donor.data.name"
                    />

                    <div v-if="donor.data.hq" class="flex items-center">
                        <svg-vue
                            icon="Map/map-pin-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <span v-text="donor.data.hq" />
                    </div>
                </div>

                <div class="sm:col-span-3 md:col-span-2">
                    <strong class="text-lg" v-text="donor.data.contact" />

                    <div v-if="donor.data.email" class="flex items-center mt-1">
                        <svg-vue
                            icon="Business/at-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`mailto:${donor.data.email}`"
                            class="hover:underline"
                            v-text="donor.data.email"
                        />
                    </div>

                    <div v-if="donor.data.phone" class="flex items-center mt-1">
                        <svg-vue
                            icon="Device/phone-line"
                            class="w-4 h-6 mr-1 text-gray-500 fill-current"
                        />

                        <a
                            :href="`tel:${donor.data.phone}`"
                            class="hover:underline"
                            v-text="donor.data.phone"
                        />
                    </div>
                </div>

                <div
                    class="sm:col-span-3 md:col-span-2"
                    v-if="donor.data.domains.length"
                >
                    <strong
                        class="text-lg"
                        v-text="$t('dashboard.field.areas')"
                    />
                    <div class="flex mt-1">
                        <svg-vue
                            icon="Design/focus-3-line"
                            class="flex-shrink-0 w-4 h-6 mr-1 text-gray-500 fill-current"
                        />
                        <div
                            v-html="
                                donor.data.domains
                                    .map((area) => area.name)
                                    .join(', ')
                            "
                        />
                    </div>
                </div>
            </div>
        </panel>

        <div class="grid gap-8 md:grid-cols-3">
            <panel class="md:col-span-2">a</panel>
            <panel title="Total Funding" icon="Weather/sun-fill">
                Total funding
            </panel>
        </div>
    </layout>
</template>
<script>
    export default {
        props: {
            donor: Object,
        },
        metaInfo() {
            return {
                title: this.donor.data.name,
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.donor.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.donor.singular').toLowerCase(),
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
            };
        },
    };
</script>
