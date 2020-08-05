<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('focus-areas.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.focusArea.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{
                $t('dashboard.action.edit', {
                    model: $t(
                        'dashboard.model.focusArea.singular'
                    ).toLowerCase(),
                })
            }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('dashboard.model.focusArea.section.title')"
                :description="
                    $t('dashboard.model.focusArea.section.description')
                "
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('dashboard.field.name')"
                    v-model="form.name"
                    :errors="$page.errors.name"
                    class="lg:col-span-2"
                    translated
                    required
                    autofocus
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    color="red"
                    :href="$route('focus-areas.index')"
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
    import Layout from '@/Shared/Layout/Default';

    import FormButton from '@/Shared/Form/Button';
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormCheckboxGroup from '@/Shared/Form/CheckboxGroup';
    import FormFile from '@/Shared/Form/File';
    import FormInput from '@/Shared/Form/Input';
    import FormPanel from '@/Shared/Form/Panel';
    import FormSelect from '@/Shared/Form/Select';

    import LocaleMixin from '@/mixins/locale';

    export default {
        components: {
            Layout,
            FormButton,
            FormCheckbox,
            FormCheckboxGroup,
            FormFile,
            FormInput,
            FormPanel,
            FormSelect,
        },
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
                    ...this.prepareFields(['name'], this.focusArea.data),
                },
            };
        },
        props: {
            focusArea: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t(
                        'dashboard.model.focusArea.singular'
                    ).toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t(
                        'dashboard.model.focusArea.singular'
                    ).toLowerCase(),
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
                        this.$route('focus-areas.update', {
                            focus_area: this.focusArea.data.id,
                        }),
                        this.prepareFormData(this.form)
                    )
                    .then(() => (this.sending = false));
            },
        },
    };
</script>
