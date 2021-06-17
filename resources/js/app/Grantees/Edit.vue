<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.grantee.section.title')"
                :description="$t('model.grantee.section.description')"
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

                <form-input
                    type="text"
                    id="tax_id"
                    :label="$t('field.tax_id')"
                    :help="$t('dashboard.help.numbers_only')"
                    v-model="form.tax_id"
                    class="lg:col-span-2"
                    :required="!form.without_tax_id"
                />

                <form-checkbox
                    v-if="!form.tax_id"
                    id="without_tax_id"
                    :label="$t('field.without_tax_id')"
                    v-model="form.without_tax_id"
                    class="lg:col-span-2"
                    :required="!form.tax_id"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    v-if="$userCanOnModel('delete', grantee)"
                    type="button"
                    color="red"
                    @click="destroy"
                    :disabled="sending"
                >
                    {{ deleteLabel }}
                </form-button>

                <form-button type="submit" color="blue" :disabled="sending">
                    {{ $t('dashboard.action.save') }}
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
                grantee: this.grantee.id,
            };

            return {
                deleteAction: this.$route('grantees.destroy', routeParams),
                formAction: this.$route('grantees.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    ...this.prepareFields(['name', 'tax_id'], this.grantee),
                    without_tax_id: !this.grantee.tax_id,
                },
            };
        },
        props: {
            grantee: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
                    model: this.$t('model.grantee.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.grantee.plural'),
                        href: this.$route('grantees.index'),
                    },
                    {
                        label: this.$t('dashboard.action.edit'),
                        href: null,
                    },
                ];
            },
        },
        watch: {
            'form.without_tax_id': function (value) {
                if (value) {
                    this.form.tax_id = null;
                }
            },
            'form.tax_id': function (value) {
                if (value) {
                    this.form.without_tax_id = false;
                }
            },
        },
    };
</script>
