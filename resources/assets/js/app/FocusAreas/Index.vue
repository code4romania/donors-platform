<template>
    <layout>
        <template v-slot:title>
            {{ $t('dashboard.model.focusArea.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('focus-areas.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <table-index
            :collection="focusAreas"
            :columns="columns"
            route="focus-areas.edit"
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
            focusAreas: Object,
        },
        metaInfo() {
            return {
                title: this.$t('dashboard.model.focusArea.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t(
                        'dashboard.model.focusArea.singular'
                    ).toLowerCase(),
                });
            },
        },
    };
</script>
