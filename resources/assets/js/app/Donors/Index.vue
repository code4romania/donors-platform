<template>
    <layout>
        <template v-slot:title>
            Donors
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('donors.create')">
                    {{ $t('donor.create') }}
                </form-button>
            </div>
        </template>

        <data-table
            :collection="$page.donors"
            route="donors.show"
            :paginate="true"
        />
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import DataTable from '@/Shared/DataTable';
    import FormButton from '@/Shared/Form/Button';

    export default {
        components: {
            Layout,
            DataTable,
            FormButton,
        },
        metaInfo() {
            return {
                title: this.$t('donor.plural'),
            };
        },
    };
</script>
