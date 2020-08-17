<template>
    <layout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('model.user.section.title')"
                :description="$t('model.user.section.description')"
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
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    color="red"
                    :href="deleteAction"
                    :disabled="sending"
                    method="delete"
                >
                    {{ deleteLabel }}
                </form-button>

                <form-button color="blue" :disabled="sending">
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
            return {
                deleteAction: this.$route('users.destroy', {
                    user: this.user.data.id,
                }),
                formAction: this.$route('users.update', {
                    user: this.user.data.id,
                }),
                form: {
                    _method: 'PUT', // html form method spoofing
                    ...this.prepareFields(
                        ['name', 'email', 'role'],
                        this.user.data
                    ),
                },
            };
        },
        props: {
            user: Object,
            roles: Array,
        },
        computed: {
            routeParams() {
                return;
            },
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
