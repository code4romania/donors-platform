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
            {{ pageTitle }}
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
                <form-button color="blue">
                    {{ submitLabel }}
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
                form: this.prepareFields(['name']),
            };
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.domain.singular').toLowerCase(),
                });
            },
        },
        methods: {
            submit() {
                this.$inertia.post(
                    this.$route('domains.store'),
                    this.prepareFormData(this.form)
                );
            },
        },
    };
</script>
