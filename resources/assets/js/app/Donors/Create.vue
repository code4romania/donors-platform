<template>
    <layout>
        <template v-slot:title>
            {{ $t('donor.title') }}
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
                    :label="$t('donor.name')"
                    v-model="form.name"
                    :errors="$page.errors.name"
                    required
                    autofocus
                />

                <form-select
                    id="type"
                    :label="$t('donor.type')"
                    v-model="form.type"
                    :errors="$page.errors.type"
                    :options="['a', 'b']"
                    required
                />

                <form-input
                    type="text"
                    id="hq"
                    :label="$t('donor.hq')"
                    v-model="form.hq"
                    :errors="$page.errors.hq"
                    required
                />

                <form-input
                    type="text"
                    id="contact"
                    :label="$t('donor.contact')"
                    v-model="form.contact"
                    :errors="$page.errors.contact"
                    required
                />

                <form-input
                    type="email"
                    id="email"
                    :label="$t('donor.email')"
                    v-model="form.email"
                    :errors="$page.errors.email"
                    required
                />

                <form-input
                    type="text"
                    id="phone"
                    :label="$t('donor.phone')"
                    v-model="form.phone"
                    :errors="$page.errors.phone"
                    required
                />

                <form-input
                    type="file"
                    id="logo"
                    :label="$t('donor.logo')"
                    v-model="form.logo"
                    :errors="$page.errors.logo"
                    class="md:col-span-2"
                    required
                />

                <form-checkbox-group
                    id="areas"
                    :label="$t('donor.areas')"
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
        metaInfo: {
            title: 'Donors',
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
