<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
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
                    v-if="$userCanOnModel('delete', grant)"
                    type="button"
                    color="red"
                    @click="destroy"
                    :disabled="form.processing"
                >
                    {{ deleteLabel }}
                </form-button>

                <form-button
                    type="button"
                    color="blue"
                    shade="light"
                    @click="changeVisibility"
                    :disabled="form.processing"
                >
                    {{ visibilityLabel }}
                </form-button>

                <form-button
                    type="submit"
                    color="blue"
                    :disabled="form.processing"
                >
                    {{ saveLabel }}
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
                managed: this.grant.manager !== null,

                deleteAction: this.$route('grants.destroy', this.grant.id),

                form: this.$inertia.form({
                    _method: 'PUT', // html form method spoofing
                    _publish: this.grant.published_status === 'published',

                    name: this.translateField('name', this.grant),
                    description: this.translateField('description', this.grant),
                    currency: this.grant.currency,
                    start_date: this.grant.start_date,
                    end_date: this.grant.end_date,
                    project_count: this.grant.project_count,
                    manager: this.grant.manager,
                    matching: this.grant.matching,
                    amount: this.grant.amount,
                    regranting_amount: this.grant.regranting_amount,
                    primary_domain: this.grant.primary_domain,
                    secondary_domains: this.grant.secondary_domains,
                    donors: this.grant.donors,
                }),
            };
        },
        props: {
            grant: Object,
            domains: Array,
            donors: Array,
            managers: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
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
                        label: this.$t('dashboard.action.edit'),
                        href: null,
                    },
                ];
            },
        },
        methods: {
            submit() {
                this.form
                    .transform(this.prepareTranslatedFields)
                    .post(this.$route('grants.update', this.grant.id));
            },
        },
    };
</script>
