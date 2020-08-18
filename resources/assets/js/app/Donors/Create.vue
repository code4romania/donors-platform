<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('model.donor.section.organization.title')"
                :description="
                    $t('model.donor.section.organization.description')
                "
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('field.name')"
                    v-model="form.name"
                    required
                    autofocus
                />

                <form-select
                    id="type"
                    :label="$t('field.type')"
                    v-model="form.type"
                    :options="['a', 'b']"
                    required
                />

                <form-input
                    type="text"
                    id="hq"
                    :label="$t('field.hq')"
                    v-model="form.hq"
                    required
                />

                <form-file
                    id="logo"
                    :label="$t('field.logo')"
                    accept="image/x-png,image/gif,image/jpeg"
                    @fileChange="form.logo = $event"
                    required
                />

                <form-checkbox-group
                    id="domains"
                    :label="$t('field.domains')"
                    :other-label="$t('field.other')"
                    v-model="form.domains"
                    class="lg:col-span-2"
                    :options="domains.data"
                    option-value-key="id"
                    option-label-key="name"
                    :other="true"
                />
            </form-panel>

            <form-panel
                :title="$t('model.donor.section.contact.title')"
                :description="$t('model.donor.section.contact.description')"
            >
                <form-input
                    type="text"
                    id="contact"
                    :label="$t('field.name')"
                    v-model="form.contact"
                    required
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('field.email')"
                    v-model="form.email"
                    required
                />

                <form-input
                    type="text"
                    id="phone"
                    :label="$t('field.phone')"
                    v-model="form.phone"
                    required
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    type="button"
                    @click.prevent="changeVisibility"
                    :disabled="sending"
                >
                    {{ draftLabel }}
                </form-button>

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
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                formAction: this.$route('donors.store'),
                form: {
                    ...this.prepareFields([
                        'name',
                        'type',
                        'hq',
                        'contact',
                        'email',
                        'phone',
                        'logo',
                    ]),
                    domains: [],
                },
            };
        },
        props: {
            domains: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.donor.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.donor.plural'),
                        href: this.$route('donors.index'),
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
