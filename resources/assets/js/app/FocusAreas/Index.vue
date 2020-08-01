<template>
    <layout>
        <template v-slot:title>
            {{ $t('focusArea.plural') }}
        </template>

        <template v-slot:actions>
            <div>
                <form-button color="blue" :href="$route('focus-areas.create')">
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <data-table
            :collection="focusAreas"
            route="focus-areas.show"
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
        props: {
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
