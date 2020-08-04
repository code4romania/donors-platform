<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.model.donor.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('donors.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <table-index
            :collection="donors"
            :columns="columns"
            route="donors.show"
            :paginate="true"
        />
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import TableIndex from '@/Shared/Table/Index';
    import FormButton from '@/Shared/Form/Button';

    export default {
        components: {
            Layout,
            TableIndex,
            FormButton,
        },
        props: {
            columns: Array,
            donors: Object,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.model.donor.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.donor.singular').toLowerCase(),
                });
            },
        },
    };
</script>
