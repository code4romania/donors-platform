<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
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
                    :options="types"
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
                    @fileChange="form.logo = $event"
                />

                <form-checkbox-group
                    id="domains"
                    :label="$t('field.domains')"
                    :other-label="$t('field.other')"
                    v-model="form.domains"
                    class="lg:col-span-2"
                    :options="domains"
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
                    v-if="$userCanOnModel('delete', donor)"
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

    export default {
        mixins: [FormMixin],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            let routeParams = {
                donor: this.donor.id,
            };

            return {
                deleteAction: this.$route('donors.destroy', routeParams),
                formAction: this.$route('donors.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    _publish: this.donor.published_status === 'published',
                    ...this.prepareFields(
                        ['name', 'type', 'hq', 'contact', 'email', 'phone'],
                        this.donor
                    ),
                    domains: this.donor.domains.map((domain) => domain.id),
                },
            };
        },
        props: {
            donor: Object,
            domains: Array,
            types: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
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
                        label: this.$t('dashboard.action.edit'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
