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

        <model-table
            :collection="focusAreas"
            :columns="columns"
            route="focus-areas.edit"
            :paginate="true"
        />
    </layout>
</template>
<script>
    import Layout from '@/Shared/Layout/Default';
    import FormButton from '@/Shared/Form/Button';
    import ModelTable from '@/Shared/ModelTable';

    export default {
        components: {
            Layout,
            FormButton,
            ModelTable,
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
