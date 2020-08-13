<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('users.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.user.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{
                $t('dashboard.action.edit', {
                    model: $t('dashboard.model.user.singular').toLowerCase(),
                })
            }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('dashboard.model.user.section.title')"
                :description="$t('dashboard.model.user.section.description')"
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('dashboard.field.name')"
                    v-model="form.name"
                    class="lg:col-span-2"
                    required
                    autofocus
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('dashboard.field.email')"
                    v-model="form.email"
                    class="lg:col-span-2"
                    required
                />

                <form-select
                    id="role"
                    :label="$t('dashboard.field.role')"
                    :options="roles"
                    v-model="form.role"
                    class="lg:col-span-2"
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    color="red"
                    :href="$route('users.index')"
                    :disabled="sending"
                >
                    {{ $t('dashboard.action.cancel') }}
                </form-button>
                <form-button color="blue" :disabled="sending">
                    {{ $t('dashboard.action.save') }}
                </form-button>
            </div>
        </form>
    </layout>
</template>
<script>
    import LocaleMixin from '@/mixins/locale';

    export default {
        mixins: [LocaleMixin],
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
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.user.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.user.singular').toLowerCase(),
                });
            },
        },
        methods: {
            submit() {
                if (this.sending) {
                    return;
                }

                this.sending = true;
                this.$inertia
                    .post(
                        this.$route('users.update', {
                            user: this.user.data.id,
                        }),
                        this.prepareFormData(this.form)
                    )
                    .then(() => (this.sending = false));
            },
        },
    };
</script>
