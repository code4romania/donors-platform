<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('domains.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('model.domain.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{
                $t('dashboard.action.edit', {
                    model: $t('model.domain.singular').toLowerCase(),
                })
            }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
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
                    color="red"
                    :href="$route('domains.index')"
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
                    ...this.prepareFields(['name'], this.domain.data),
                },
            };
        },
        props: {
            domain: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('model.domain.singular').toLowerCase(),
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
                        this.$route('domains.update', {
                            domain: this.domain.data.id,
                        }),
                        this.prepareFormData(this.form)
                    )
                    .then(() => (this.sending = false));
            },
        },
    };
</script>
