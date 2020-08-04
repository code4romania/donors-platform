<template>
    <div class="leading-tight text-gray-900">
        <div class="max-w-full overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <table-head :columns="columns" />
                <table-body
                    :columns="columns"
                    :data="collection.data"
                    :route="route"
                />
            </table>
        </div>

        <pagination v-if="paginate" class="mt-4" :collection="collection" />
    </div>
</template>

<script>
    import Pagination from '@/Shared/Pagination';
    import TableHead from '@/Shared/Table/Head';
    import TableBody from '@/Shared/Table/Body';

    export default {
        components: {
            TableHead,
            TableBody,
            Pagination,
        },
        props: {
            collection: {
                type: Object,
                required: true,
            },
            columns: {
                type: Array,
                required: true,
            },
            route: {
                type: String,
                required: true,
            },
            paginate: {
                type: Boolean,
                default: true,
            },
        },
    };
</script>
