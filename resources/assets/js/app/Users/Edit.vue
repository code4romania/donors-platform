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
                    :options="translatedRoles"
                    v-model="form.role"
                    class="lg:col-span-2"
                />
            </form-panel>

            <!-- <form-panel
                v-if="form.role === 'user'"
                :title="$t('model.user.section.permissions.title')"
                :description="$t('model.user.section.permissions.description')"
            >
                <template v-for="(group, index) in permissionsByGroup">
                    <form-checkbox-group
                        id="permissions"
                        :key="index"
                        :label="group.label"
                        v-model="form.permissions[group.model]"
                        class="lg:col-span-2"
                        :options="group.permissions"
                        option-value-key="action"
                        option-label-key="label"
                    />
                </template>
            </form-panel> -->

            <form-panel
                v-if="form.role === 'user'"
                :title="$t('model.user.section.permissions.title')"
                :description="$t('model.user.section.permissions.description')"
            >
                <form-checkbox-group
                    id="donors"
                    :label="$t('model.donor.plural')"
                    v-model="form.donors"
                    class="lg:col-span-2"
                    :options="donors"
                    option-value-key="id"
                    option-label-key="name"
                />

                <form-checkbox-group
                    id="managers"
                    :label="$t('model.manager.plural')"
                    v-model="form.managers"
                    class="lg:col-span-2"
                    :options="managers"
                    option-value-key="id"
                    option-label-key="name"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
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
                    permissions: this.permissionValues(),
                    donors: this.user.donors,
                    managers: this.user.managers,
                    ...this.prepareFields(['name', 'email', 'role'], this.user),
                },
            };
        },
        props: {
            user: Object,
            roles: Array,
            permissions: Object,
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
        methods: {
            permissionValues() {
                let permissions = {};

                Object.keys(this.permissions).map((model) => {
                    if (!permissions.hasOwnProperty(model)) {
                        permissions[model] = [];
                    }

                    let capabilities = this.user.permissions[model + 's'];

                    permissions[model] = Object.keys(capabilities).filter(
                        (action) => capabilities[action] === true
                    );
                });

                return permissions;
            },
        },
    };
</script>
