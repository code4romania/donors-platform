<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.manager.section.organization.title')"
                :description="
                    $t('model.manager.section.organization.description')
                "
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

                <form-select
                    id="domains"
                    :label="$t('field.domains')"
                    v-model="form.domains"
                    class="lg:col-span-2"
                    :options="domains"
                    option-value-key="id"
                    option-label-key="name"
                    :multiple="true"
                />
            </form-panel>

            <form-panel
                :title="$t('model.manager.section.contact.title')"
                :description="$t('model.manager.section.contact.description')"
            >
                <form-input
                    type="text"
                    id="contact"
                    :label="$t('field.name')"
                    v-model="form.contact"
                    class="lg:col-span-2"
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
                    v-if="$userCanOnModel('delete', manager)"
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
                manager: this.manager.id,
            };

            return {
                deleteAction: this.$route('managers.destroy', routeParams),
                formAction: this.$route('managers.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    _publish: this.manager.published_status === 'published',
                    ...this.prepareFields(
                        ['name', 'hq', 'contact', 'email', 'phone'],
                        this.manager
                    ),
                    domains: this.manager.domains.map((area) => area.id),
                },
            };
        },
        props: {
            manager: Object,
            domains: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
                    model: this.$t('model.manager.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.manager.plural'),
                        href: this.$route('managers.index'),
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
