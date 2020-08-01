<template>
    <layout>
        <template v-slot:title>
            <inertia-link
                :href="$route('donors.index')"
                class="text-blue-500 hover:text-blue-600"
            >
                {{ $t('dashboard.model.donor.plural') }}
            </inertia-link>
            <span class="font-normal text-gray-300" aria-hidden="true">//</span>
            {{
                $t('dashboard.action.edit', {
                    model: $t('dashboard.model.donor.singular').toLowerCase(),
                })
            }}
        </template>

        <form @submit.prevent="submit" method="post" class="grid row-gap-8">
            <form-panel
                :title="$t('dashboard.model.donor.section.organization.title')"
                :description="
                    $t('dashboard.model.donor.section.organization.description')
                "
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('dashboard.field.name')"
                    v-model="form.name"
                    :errors="$page.errors.name"
                    required
                    autofocus
                />

                <form-select
                    id="type"
                    :label="$t('dashboard.field.type')"
                    v-model="form.type"
                    :errors="$page.errors.type"
                    :options="['a', 'b']"
                    required
                />

                <form-input
                    type="text"
                    id="hq"
                    :label="$t('dashboard.field.hq')"
                    v-model="form.hq"
                    :errors="$page.errors.hq"
                    required
                />

                <form-file
                    id="logo"
                    :label="$t('dashboard.field.logo')"
                    @fileChange="form.logo = $event"
                    :errors="$page.errors.logo"
                />

                <form-checkbox-group
                    id="areas"
                    :label="$t('dashboard.field.areas')"
                    :other-label="$t('dashboard.field.other')"
                    v-model="form.areas"
                    class="lg:col-span-2"
                    :options="['a', 'b', 'c', 'd', 'e']"
                    :other="true"
                />
            </form-panel>

            <form-panel
                :title="$t('dashboard.model.donor.section.contact.title')"
                :description="
                    $t('dashboard.model.donor.section.contact.description')
                "
            >
                <form-input
                    type="text"
                    id="contact"
                    :label="$t('dashboard.field.name')"
                    v-model="form.contact"
                    :errors="$page.errors.contact"
                    required
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('dashboard.field.email')"
                    v-model="form.email"
                    :errors="$page.errors.email"
                    required
                />

                <form-input
                    type="text"
                    id="phone"
                    :label="$t('dashboard.field.phone')"
                    v-model="form.phone"
                    :errors="$page.errors.phone"
                    required
                />
            </form-panel>

            <div class="flex justify-end space-x-3">
                <form-button
                    color="red"
                    :href="$route('donors.show', { donor: donor.id })"
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
                    name: this.donor.name,
                    type: this.donor.type,
                    hq: this.donor.hq,
                    contact: this.donor.contact,
                    email: this.donor.email,
                    phone: this.donor.phone,
                    areas: this.donor.areas,
                },
            };
        },
        props: {
            donor: Object,
        },
        computed: {
            pageTitle() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.donor.singular').toLowerCase(),
                });
            },
            submitLabel() {
                return this.$t('dashboard.action.edit', {
                    model: this.$t('dashboard.model.donor.singular').toLowerCase(),
                });
            },
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

                this.$inertia.post(this.$route('donors.update'), formData);
            },
        },
    };
</script>
