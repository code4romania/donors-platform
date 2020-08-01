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
                    required
                    autofocus
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    color="red"
                    :href="
                        $route('focus-areas.show', { focus_area: focusArea.id })
                    "
                >
                    {{ $t('dashboard.cancel') }}
                </form-button>
                <form-button color="blue">
                    {{ $t('dashboard.save') }}
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
    import Panel from '@/Shared/Panel';

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
            Panel,
        },
        metaInfo() {
            return {
                title: this.pageTitle,
            };
        },
        data() {
            return {
                form: {
                    name: this.focusArea.name,
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
                this.$inertia.put(
                    this.$route('focus-areas.update', {
                        focus_area: this.focusArea.id,
                    }),
                    this.form
                );
            },
        },
    };
</script>
