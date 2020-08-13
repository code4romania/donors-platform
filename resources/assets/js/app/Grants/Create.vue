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

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('dashboard.model.grant.section.info.title')"
                :description="
                    $t('dashboard.model.grant.section.info.description')
                "
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('dashboard.field.name')"
                    v-model="form.name"
                    class="lg:col-span-2"
                    required
                    autofocus
                />

                <form-select
                    id="grantees"
                    :label="$t('dashboard.model.grantee.plural')"
                    :options="grantees.data"
                    v-model="form.grantees"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                    multiple
                />

                <form-select
                    id="area"
                    :label="$t('dashboard.model.domain.singular')"
                    :options="domains.data"
                    v-model="form.area"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                />

                <form-date-picker
                    id="start_date"
                    :label="$t('dashboard.field.start_date')"
                    v-model="form.start_date"
                    required
                />

                <form-date-picker
                    id="end_date"
                    :label="$t('dashboard.field.end_date')"
                    v-model="form.end_date"
                    required
                />

                <form-input
                    type="number"
                    id="amount"
                    :label="$t('dashboard.field.grant_value')"
                    v-model="form.amount"
                    step="0.01"
                    required
                />

                <form-select
                    id="currency"
                    :label="$t('dashboard.field.currency')"
                    :options="$page.currencies"
                    v-model="form.currency"
                    required
                />

                <form-checkbox
                    id="managed"
                    :label="$t('dashboard.field.managed')"
                    v-model="managed"
                />
            </form-panel>

            <form-panel
                :title="$t('dashboard.model.grant.section.donors.title')"
                :description="
                    $t('dashboard.model.grant.section.donors.description')
                "
            >
                <form-select
                    id="donors"
                    :label="$t('dashboard.model.donor.plural')"
                    :options="donors.data"
                    v-model="form.donors"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                    multiple
                />
            </form-panel>

            <form-panel
                :title="$t('dashboard.model.grant.section.manager.title')"
                :description="
                    $t('dashboard.model.grant.section.manager.description')
                "
                v-if="managed"
            >
                <form-select
                    id="manager"
                    :label="$t('dashboard.model.manager.singular')"
                    :options="[]"
                    v-model="form.manager"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                />

                <form-input
                    type="number"
                    id="regranting"
                    :label="$t('dashboard.field.regranting_value')"
                    v-model="form.regranting"
                    step="0.01"
                    required
                />

                <form-select
                    id="currency"
                    :label="$t('dashboard.field.currency')"
                    :options="$page.currencies"
                    v-model="form.regranting_currency"
                    required
                />

                <form-checkbox
                    id="matching"
                    :label="$t('matching funds')"
                    v-model="matching"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button color="blue">
                    {{ submitLabel }}
                </form-button>
            </div>
        </form>
    </layout>
</template>
<script>
    import LocaleMixin from '@/mixins/locale';

    export default {
        mixins: [LocaleMixin],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                managed: false,
                form: {
                    grantees: [],
                    ...this.prepareFields([
                        'name',
                        'area',
                        'start_date',
                        'end_date',
                        'amount',
                    ]),
                },
            };
        },
        props: {
            domains: Object,
            grantees: Object,
            donors: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.grant.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.grant.singular').toLowerCase(),
                });
            },
        },
        methods: {
            submit() {
                this.$inertia.post(
                    this.$route('grants.store'),
                    this.prepareFormData(this.form)
                );
            },
        },
    };
</script>
