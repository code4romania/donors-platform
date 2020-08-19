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
                    required
                    autofocus
                />

                <form-select
                    id="domain"
                    :label="$t('model.domain.singular')"
                    :options="domains.data"
                    v-model="form.domain"
                    class="lg:col-span-2"
                    option-value-key="id"
                    option-label-key="name"
                    required
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
                    :options="$page.currencies"
                    v-model="form.currency"
                    required
                />

                <form-input
                    type="number"
                    id="donor_count"
                    :label="$t('field.donor_count')"
                    v-model.number="form.donor_count"
                    required
                    min="1"
                    max="100"
                />

                <form-input
                    type="number"
                    id="grantee_count"
                    :label="$t('field.grantee_count')"
                    v-model.number="form.grantee_count"
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
                        v-for="(_, index) in form.donor_count"
                        :key="index"
                        id="donors"
                        :label="$t('model.donor.singular') + ` #${index + 1}`"
                        :options="donors.data"
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
                    :label="$t('model.user.singular')"
                    :options="managers.data"
                    v-model="form.manager"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                    required
                />

                <form-input
                    type="number"
                    id="regranting"
                    :label="$t('field.regranting_value')"
                    v-model="form.regranting"
                    min="0"
                    step="0.01"
                    required
                    :max="this.form.amount"
                />

                <form-checkbox
                    id="matching"
                    :label="$t('matching funds')"
                    v-model="form.matching"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    type="button"
                    color="red"
                    @click="destroy"
                    :disabled="sending"
                >
                    {{ deleteLabel }}
                </form-button>

                <form-button
                    type="button"
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

    export default {
        mixins: [FormMixin],
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
                managed: false,
                deleteAction: this.$route('grants.destroy', routeParams),
                formAction: this.$route('grants.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    _publish: this.grant.published_status === 'published',
                    donors: Object.keys(this.grant.donors),
                    grantee_count: 1,
                    donor_count: Object.keys(this.grant.donors).length,
                    regranting: 0,
                    domain: this.grant.domain.id || null,
                    matching: false,
                    ...this.prepareFields(
                        ['name', 'amount', 'currency', 'start_date', 'end_date'],
                        this.grant
                    ),
                },
            };
        },
        props: {
            grant: Object,
            domains: Object,
            donors: Object,
            managers: Object,
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
        watch: {
            'form.donor_count': {
                handler(newValue, oldValue) {
                    if (newValue > oldValue) {
                        this.form.donors = this.form.donors.concat(
                            Array(newValue - this.form.donors.length).fill(null)
                        );
                    } else {
                        this.form.donors.splice(newValue);
                    }
                },
            },
        },
    };
</script>
