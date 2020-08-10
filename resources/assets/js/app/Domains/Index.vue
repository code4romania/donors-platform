<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.model.domain.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('domains.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="domains"
            :columns="columns"
            route="domains.edit"
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
            domains: Object,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.model.domain.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.domain.singular').toLowerCase(),
                });
            },
        },
    };
</script>
