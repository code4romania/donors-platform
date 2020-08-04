<template>
    <thead>
        <tr class="font-semibold leading-tight text-left">
            <th
                class="px-6 py-4"
                v-for="(column, index) in columns"
                :key="index"
                v-text="$t('dashboard.field.' + column)"
            />
        </tr>
    </thead>
</template>

<script>
    export default {
        props: {
            columns: {
                type: Array,
                required: true,
                default: () => [],
            },
        },
    };
</script>
