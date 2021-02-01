<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="publish" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.grant.section.info.title')"
                :description="$t('model.grant.section.info.description')"
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('field.name')"
                    v-model="form.name"
                    class="lg:col-span-2"
                    translated
                    required
                    autofocus
                />

                <form-input
                    type="textarea"
                    id="description"
                    :label="$t('field.description')"
                    v-model="form.description"
                    class="lg:col-span-2"
                    translated
                />

                <form-select
                    id="primary_domain"
                    :label="$t('model.domain.primary')"
                    :options="domains"
                    option-value-key="id"
                    option-label-key="name"
                    v-model="form.primary_domain"
                    required
                />

                <form-select
                    id="secondary_domains"
                    :label="$t('model.domain.secondary')"
                    :options="domains"
                    option-value-key="id"
                    option-label-key="name"
                    :multiple="true"
                    v-model="form.secondary_domains"
                />

                <form-date-picker
                    id="start_date"
                    :label="$t('field.start_date')"
                    v-model="form.start_date"
                    required
                />

                <form-date-picker
                    id="end_date"
                    :label="$t('field.end_date')"
                    v-model="form.end_date"
                    required
                />

                <form-input
                    type="number"
                    id="amount"
                    :label="$t('field.grant_value')"
                    v-model.number="form.amount"
                    min="0"
                    required
                />

                <form-select
                    id="currency"
                    :label="$t('field.currency')"
                    :options="$page.props.currencies"
                    v-model="form.currency"
                    required
                />

                <form-input
                    type="number"
                    id="project_count"
                    :label="$t('field.project_count')"
                    v-model.number="form.project_count"
                    required
                    min="1"
                />

                <form-checkbox
                    id="managed"
                    :label="$t('field.managed')"
                    v-model="managed"
                />
            </form-panel>

            <form-panel
                :title="$t('model.grant.section.donors.title')"
                :description="$t('model.grant.section.donors.description')"
            >
                <donors-with-amounts
                    :donors="donors"
                    :currency="form.currency"
                    :max-amount="form.amount"
                    v-model="form.donors"
                    class="lg:col-span-2"
                />
            </form-panel>

            <form-panel
                :title="$t('model.grant.section.manager.title')"
                :description="$t('model.grant.section.manager.description')"
                v-if="managed"
            >
                <form-select
                    id="manager"
                    :label="$t('model.manager.singular')"
                    :options="managers"
                    v-model="form.manager"
                    option-value-key="id"
                    option-label-key="name"
                    :option-placeholder="$t('field.none')"
                    class="lg:col-span-2"
                />

                <form-input
                    type="number"
                    id="regranting_amount"
                    :label="$t('field.regranting_amount')"
                    v-model="form.regranting_amount"
                    min="0"
                    required
                    :max="this.form.amount"
                />

                <form-checkbox
                    id="matching"
                    :label="$t('field.matching_funds')"
                    v-model="form.matching"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    type="button"
                    color="blue"
                    shade="light"
                    @click="draft"
                    :disabled="form.processing"
                >
                    {{ draftLabel }}
                </form-button>

                <form-button
                    type="submit"
                    color="blue"
                    :disabled="form.processing"
                >
                    {{ createLabel }}
                </form-button>
            </div>
        </form>
    </layout>
</template>

<script>
    import FormMixin from '@/mixins/form';

    export default {
        mixins: [
            //
            FormMixin,
        ],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                managed: false,

                form: this.$inertia.form({
                    _publish: true,
                    name: this.translateField('name'),
                    description: this.translateField('description'),
                    currency: null,
                    start_date: null,
                    end_date: null,
                    project_count: null,
                    manager: null,
                    matching: null,
                    amount: null,
                    regranting_amount: null,
                    primary_domain: null,
                    secondary_domains: null,
                    donors: this.prefillDonor(),
                }),
            };
        },
        props: {
            domains: Array,
            donors: Array,
            managers: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.grant.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grant.plural'),
                        href: this.$route('grants.index'),
                    },
                    {
                        label: this.$t('dashboard.action.create'),
                        href: null,
                    },
                ];
            },
        },
        methods: {
            prefillDonor() {
                let search = new URLSearchParams(location.search),
                    donor = search.get('donor');

                if (!donor) {
                    return [];
                }

                return [
                    {
                        id: parseInt(donor),
                        amount: 0,
                    },
                ];
            },
            submit() {
                this.form
                    .transform(this.prepareTranslatedFields)
                    .post(this.$route('grants.store'));
            },
        },
    };
</script>
