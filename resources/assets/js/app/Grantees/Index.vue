<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.model.grantee.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('grantees.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="grantees"
            :columns="columns"
            route="grantees.edit"
            :paginate="true"
        />
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import FormButton from '@/Shared/Form/Button';
    import ModelTable from '@/Shared/Table/Model';

    export default {
        components: {
            Layout,
            FormButton,
            ModelTable,
        },
        props: {
            columns: Array,
            grantees: Object,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.model.grantee.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t(
                        'dashboard.model.grantee.singular'
                    ).toLowerCase(),
                });
            },
        },
    };
</script>
