<template>
    <tbody>
        <table-row
            v-for="(row, rowIndex) in data"
            :key="rowIndex"
            :columns="columns"
            :data="row"
            :route="route"
        />
    </tbody>
</template>

<script>
    import TableRow from '@/Shared/Table/Row';

    export default {
        components: {
            TableRow,
        },
        props: {
            columns: {
                type: Array,
                required: true,
            },
            data: {
                type: Array,
                required: true,
            },
            route: {
                type: String,
                required: true,
            },
        },
    };
</script>
