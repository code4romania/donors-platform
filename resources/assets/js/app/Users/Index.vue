<template>
    <layout :breadcrumbs="breadcrumbs">
        <template v-slot:actions>
            <div>
                <form-button
                    v-if="$userCan('create', 'users')"
                    color="blue"
                    :href="$route('users.create')"
                >
                    {{ createLabel }}
                </form-button>
            </div>
        </template>

        <search-filter v-model="search" @reset="reset" />

        <model-table
            :collection="users"
            :columns="columns"
            route-name="users.edit"
            :paginate="true"
        >
            <template v-slot:role="{ role }">
                {{ $t(`dashboard.role.${role}`) }}
            </template>

            <template v-slot:organization="{ organization }">
                {{ organization ? organization.name : '' }}
            </template>
        </model-table>
    </layout>
</template>

<script>
    import FilterMixin from '@/mixins/filter';

    export default {
        mixins: [FilterMixin],
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
                return this.$t('dashboard.action.createModel', {
                    model: this.$t('model.user.singular').toLowerCase(),
                });
            },
            breadcrumbs() {
                return [
                    {
                        label: this.$t('model.user.plural'),
                        href: null,
                    },
                ];
            },
        },
    };
</script>
