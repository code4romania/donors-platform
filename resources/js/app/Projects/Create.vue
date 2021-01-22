<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.project.section.info.title')"
                :description="$t('model.project.section.info.description')"
            >
                <form-input
                    type="text"
                    id="title"
                    :label="$t('field.title')"
                    v-model="form.title"
                    class="lg:col-span-2"
                    autofocus
                />

                <form-input
                    type="number"
                    id="amount"
                    :label="$t('field.amount')"
                    v-model.number="form.amount"
                    :suffix="grant.currency"
                    min="0"
                    required
                />

                <form-input
                    type="number"
                    id="grantees_count"
                    :label="$t('field.grantees_count')"
                    v-model.number="grantees_count"
                    ref="grantees_count"
                    required
                    min="1"
                    max="10"
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
            </form-panel>

            <form-panel
                :title="$t('model.project.section.grantees.title')"
                :description="$t('model.project.section.grantees.description')"
            >
                <grid class="gap-y-4 lg:col-span-2">
                    <form-select
                        v-for="(_, index) in form.grantees"
                        :key="index"
                        id="grantees"
                        :label="$t('model.grantee.singular') + ` #${index + 1}`"
                        :options="grantees.data"
                        v-model="form.grantees[index]"
                        option-value-key="id"
                        option-label-key="name"
                        :clearable="false"
                        required
                    />
                </grid>
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button type="submit" color="blue" :disabled="sending">
                    {{ createLabel }}
                </form-button>
            </div>
        </form>
    </layout>
</template>

<script>
    import FormMixin from '@/mixins/form';
    import GranteeCountMixin from '@/mixins/granteeCount';

    export default {
        mixins: [
            //
            FormMixin,
            GranteeCountMixin,
        ],
        props: {
            columns: Array,
            grant: Object,
            grantees: Object,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                grantees_count: 1,
                formAction: this.$route('projects.store', { grant: this.grant.id }),
                form: {
                    grantees: [],
                    ...this.prepareFields(['title']),
                },
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.project.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grant.plural'),
                        href: this.$route('grants.index'),
                    },
                    {
                        label: this.grant.name,
                        href: this.$route('grants.show', { grant: this.grant.id }),
                    },
                    {
                        label: this.pageTitle,
                        href: null,
                    },
                ];
            },
        },
    };
</script>
