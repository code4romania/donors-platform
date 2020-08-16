<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('grants.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('model.grant.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            <inertia-link
                :href="$route('grants.show', { grant: grant.id })"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ grant.name }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ pageTitle }}
        </template>

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
        props: {
            project: Object,
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
                sending: false,
                form: {
                    _method: 'PUT', // html form method spoofing
                    ...this.prepareFields(
                        ['title', 'grantee', 'amount', 'start_date', 'end_date'],
                        this.project
                    ),
                },
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('model.project.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('model.project.singular').toLowerCase(),
                });
            },
        },
        methods: {
            submit() {
                this.$inertia.post(
                    this.$route('projects.update', {
                        grant: this.grant.id,
                        project: this.project.id,
                    }),
                    this.prepareFormData(this.form)
                );
            },
        },
    };
</script>
