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

        <panel>
            <form
                @submit.prevent="submit"
                method="post"
                class="grid gap-8 md:grid-cols-2"
            >
                <form-input
                    type="text"
                    id="name"
                    :label="$t('donor.field.name')"
                    v-model="form.name"
                    :errors="$page.errors.name"
                    required
                    autofocus
                />

                <form-select
                    id="type"
                    :label="$t('donor.field.type')"
                    v-model="form.type"
                    :errors="$page.errors.type"
                    :options="['a', 'b']"
                    required
                />

                <form-input
                    type="text"
                    id="hq"
                    :label="$t('donor.field.hq')"
                    v-model="form.hq"
                    :errors="$page.errors.hq"
                    required
                />

                <form-input
                    type="text"
                    id="contact"
                    :label="$t('donor.field.contact')"
                    v-model="form.contact"
                    :errors="$page.errors.contact"
                    required
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('donor.field.email')"
                    v-model="form.email"
                    :errors="$page.errors.email"
                    required
                />

                <form-input
                    type="text"
                    id="phone"
                    :label="$t('donor.field.phone')"
                    v-model="form.phone"
                    :errors="$page.errors.phone"
                    required
                />

                <form-input
                    type="file"
                    id="logo"
                    :label="$t('donor.field.logo')"
                    v-model="form.logo"
                    :errors="$page.errors.logo"
                    class="md:col-span-2"
                    required
                />

                <form-checkbox-group
                    id="areas"
                    :label="$t('donor.field.areas')"
                    :other-label="$t('donor.field.other')"
                    v-model="form.areas"
                    class="md:col-span-2"
                    :options="['a', 'b', 'c', 'd', 'e']"
                    :other="true"
                />
            </form>
        </panel>
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import FormInput from '@/Shared/Form/Input';
    import FormSelect from '@/Shared/Form/Select';
    import FormCheckbox from '@/Shared/Form/Checkbox';
    import FormCheckboxGroup from '@/Shared/Form/CheckboxGroup';
    import FormButton from '@/Shared/Form/Button';
    import Panel from '@/Shared/Panel';

    export default {
        components: {
            Layout,
            FormInput,
            FormSelect,
            FormCheckbox,
            FormCheckboxGroup,
            FormButton,
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
    };
</script>
