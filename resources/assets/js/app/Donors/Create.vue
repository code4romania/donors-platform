<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('donors.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('donor.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{ $t('donor.create') }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('donor.section.organization.title')"
                :description="$t('donor.section.organization.description')"
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('model.field.name')"
                    v-model="form.name"
                    :errors="$page.errors.name"
                    required
                    autofocus
                />

                <form-select
                    id="type"
                    :label="$t('model.field.type')"
                    v-model="form.type"
                    :errors="$page.errors.type"
                    :options="['a', 'b']"
                    required
                />

                <form-input
                    type="text"
                    id="hq"
                    :label="$t('model.field.hq')"
                    v-model="form.hq"
                    :errors="$page.errors.hq"
                    required
                />

                <form-input
                    type="file"
                    id="logo"
                    :label="$t('model.field.logo')"
                    v-model="form.logo"
                    :errors="$page.errors.logo"
                    required
                />

                <form-checkbox-group
                    id="areas"
                    :label="$t('model.field.areas')"
                    :other-label="$t('model.field.other')"
                    v-model="form.areas"
                    class="lg:col-span-2"
                    :options="['a', 'b', 'c', 'd', 'e']"
                    :other="true"
                />
            </form-panel>

            <form-panel
                :title="$t('donor.section.contact.title')"
                :description="$t('donor.section.contact.description')"
            >
                <form-input
                    type="text"
                    id="contact"
                    :label="$t('model.field.name')"
                    v-model="form.contact"
                    :errors="$page.errors.contact"
                    required
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('model.field.email')"
                    v-model="form.email"
                    :errors="$page.errors.email"
                    required
                />

                <form-input
                    type="text"
                    id="phone"
                    :label="$t('model.field.phone')"
                    v-model="form.phone"
                    :errors="$page.errors.phone"
                    required
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button color="blue">
                    {{ $t('donor.create') }}
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
            FormInput,
            FormPanel,
            FormSelect,
            Panel,
        },
        metaInfo() {
            return {
                title: this.$t('donor.create'),
            };
        },
        data() {
            return {
                form: {
                    name: null,
                    type: null,
                    hq: null,
                    contact: null,
                    email: null,
                    phone: null,
                    areas: [],
                },
            };
        },
        methods: {
            submit() {
                let formData = new FormData();

                for (const field in this.form) {
                    let value = Array.isArray(this.form[field])
                        ? JSON.stringify(this.form[field])
                        : this.form[field];

                    formData.append(field, value);

                    console.log(field, value);
                }

                this.$inertia.post(this.$route('donors.store'), formData);
            },
        },
    };
</script>
