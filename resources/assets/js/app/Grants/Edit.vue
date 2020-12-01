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
                    v-model="form.amount"
                    step="0.01"
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
                    id="donor_count"
                    ref="donor_count"
                    :label="$t('field.donor_count')"
                    v-model.number="donor_count"
                    required
                    min="1"
                    max="10"
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
                <grid class="gap-y-4 lg:col-span-2">
                    <form-select
                        v-for="(_, index) in form.donors"
                        :key="index"
                        id="donors"
                        :label="$t('model.donor.singular') + ` #${index + 1}`"
                        :options="donors"
                        v-model="form.donors[index]"
                        option-value-key="id"
                        option-label-key="name"
                        required
                    />
                </grid>
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
                    step="0.01"
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
                    :disabled="sending"
                >
                    {{ deleteLabel }}
                </form-button>

                <form-button
                    type="button"
                    color="blue"
                    shade="light"
                    @click="changeVisibility"
                    :disabled="sending"
                >
                    {{ visibilityLabel }}
                </form-button>

                <form-button type="submit" color="blue" :disabled="sending">
                    {{ saveLabel }}
                </form-button>
            </div>
        </form>
    </layout>
</template>

<script>
    import FormMixin from '@/mixins/form';
    import DonorCountMixin from '@/mixins/donorCount';

    export default {
        mixins: [
            //
            FormMixin,
            DonorCountMixin,
        ],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            let routeParams = {
                grant: this.grant.id,
            };

            return {
                managed: this.grant.manager !== null,
                donor_count: Object.keys(this.grant.donors).length || 1,

                deleteAction: this.$route('grants.destroy', routeParams),
                formAction: this.$route('grants.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    _publish: this.grant.published_status === 'published',
                    donors: Object.keys(this.grant.donors),
                    ...this.prepareFields(
                        [
                            'name',
                            'description',
                            'currency',
                            'start_date',
                            'end_date',
                            'project_count',
                            'manager',
                            'matching',
                            'amount',
                            'regranting_amount',
                            'primary_domain',
                            'secondary_domains',
                        ],
                        this.grant
                    ),
                },
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
    };
</script>
