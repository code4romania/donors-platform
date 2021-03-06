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
                    accept="image/x-png,image/gif,image/jpeg"
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
                    type="button"
                    color="blue"
                    shade="light"
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
                formAction: this.$route('managers.store'),
                form: {
                    ...this.prepareFields([
                        'name',
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
            domains: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.createModel', {
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
                        label: this.$t('dashboard.action.create'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
