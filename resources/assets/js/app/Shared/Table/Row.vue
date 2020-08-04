<template>
    <tr
        class="border-t border-gray-100 hover:bg-blue-50 focus-within:bg-blue-50"
    >
        <td v-for="(column, columnIndex) in columns" :key="columnIndex">
            <inertia-link
                class="block px-6 py-4 focus:outline-none"
                :href="$route(route, data.id)"
                :tabindex="columnIndex === 0 ? false : -1"
            >
                <template v-if="column === 'published_status'">
                    <published-badge :status="data[column]" />
                </template>
                <template v-else>
                    {{ data[column] }}
                </template>
            </inertia-link>
        </td>
    </tr>
</template>

<script>
    import PublishedBadge from '@/Shared/Badge/Published';

    export default {
        components: {
            PublishedBadge,
        },
        props: {
            columns: {
                type: Array,
                required: true,
            },
            data: {
                type: Object,
                required: true,
            },
            route: {
                type: String,
                required: true,
            },
        },
    };
</script>
