<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid gap-y-8">
            <form-panel
                :title="$t('model.user.section.info.title')"
                :description="$t('model.user.section.info.description')"
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
                    type="email"
                    id="email"
                    :label="$t('field.email')"
                    v-model="form.email"
                    class="lg:col-span-2"
                    required
                />

                <form-select
                    id="role"
                    :label="$t('field.role')"
                    :options="roles"
                    v-model="form.role"
                    class="lg:col-span-2"
                />

                <form-select
                    v-if="['donor', 'manager'].includes(form.role)"
                    id="organization_id"
                    :label="organizationLabel"
                    :options="organizationsForRole"
                    option-value-key="id"
                    option-label-key="name"
                    v-model="form.organization_id"
                    class="lg:col-span-2"
                    required
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    v-if="$userCanOnModel('delete', user)"
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
    import UserMixin from '@/mixins/user';

    export default {
        mixins: [
            //
            FormMixin,
            UserMixin,
        ],
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            let routeParams = {
                user: this.user.id,
            };

            return {
                deleteAction: this.$route('users.destroy', routeParams),
                formAction: this.$route('users.update', routeParams),
                form: {
                    _method: 'PUT', // html form method spoofing
                    donors: this.user.donors,
                    managers: this.user.managers,

                    ...this.prepareFields(
                        ['name', 'email', 'role', 'organization_id'],
                        this.user
                    ),
                },
            };
        },
        props: {
            user: Object,
            roles: Array,
            donors: Array,
            managers: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.editModel', {
                    model: this.$t('model.user.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.user.plural'),
                        href: this.$route('users.index'),
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
