<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('model.project.section.title')"
                :description="$t('model.project.section.description')"
            >
                <form-input
                    type="text"
                    id="title"
                    :label="$t('field.title')"
                    v-model="form.title"
                    class="lg:col-span-2"
                    required
                    autofocus
                />

                <form-select
                    id="grantee"
                    :label="$t('model.grantee.singular')"
                    :options="grantees.data"
                    v-model="form.grantee"
                    option-value-key="id"
                    option-label-key="name"
                    class="lg:col-span-2"
                    required
                />

                <form-input
                    type="number"
                    id="amount"
                    :label="$t('field.amount')"
                    v-model="form.amount"
                    class="lg:col-span-2"
                    :suffix="grant.currency"
                    step="0.01"
                    min="0"
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

    export default {
        mixins: [FormMixin],
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
                formAction: this.$route('projects.store', { grant: this.grant.id }),
                form: this.prepareFields(['title']),
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.create', {
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
                        label: this.$t('dashboard.action.create'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
