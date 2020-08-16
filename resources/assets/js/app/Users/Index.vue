<template>
    <layout>
        <template v-slot:title>
            {{ $t('model.user.plural') }}
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
    export default {
        props: {
            columns: Array,
            users: Object,
        },
        metaInfo() {
            return {
                title: this.$t('model.user.plural'),
            };
        },
        computed: {
            createLabel() {
                return this.$t('dashboard.action.create', {
                    model: this.$t('model.user.singular').toLowerCase(),
                });
            },
        },
    };
</script>
