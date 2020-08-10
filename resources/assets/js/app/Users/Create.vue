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
            {{ pageTitle }}
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
                    autofocus
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('dashboard.field.email')"
                    v-model="form.email"
                    class="lg:col-span-2"
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
                <form-button color="blue">
                    {{ submitLabel }}
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
                form: this.prepareFields(['name', 'email', 'role']),
            };
        },
        props: {
            roles: Array,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.user.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.user.singular').toLowerCase(),
                });
            },
        },
        methods: {
            submit() {
                this.$inertia.post(
                    this.$route('users.store'),
                    this.prepareFormData(this.form)
                );
            },
        },
    };
</script>
