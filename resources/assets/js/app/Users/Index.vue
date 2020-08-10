<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.model.user.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('users.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <model-table
            :collection="users"
            :columns="columns"
            route="users.edit"
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
            users: Object,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.model.user.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('dashboard.model.user.singular').toLowerCase(),
                });
            },
        },
    };
</script>
