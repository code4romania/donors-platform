<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.domain.section.title')"
                :description="$t('model.domain.section.description')"
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
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    v-if="$userCanOnModel('delete', domain)"
                    type="button"
                    color="red"
                    @click="destroy"
                    :disabled="sending"
                >
                    {{ deleteLabel }}
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
                domain: this.domain.id,
            };

            return {
                deleteAction: this.$route('domains.destroy', routeParams),
                formAction: this.$route('domains.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    ...this.prepareFields(['name'], this.domain),
                },
            };
        },
        props: {
            domain: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.domain.plural'),
                        href: this.$route('domains.index'),
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
