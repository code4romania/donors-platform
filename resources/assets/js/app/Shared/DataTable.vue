<template>
    <div class="leading-tight text-gray-900">
        <div class="max-w-full overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="font-semibold leading-tight text-left">
                        <th
                            class="px-6 py-4"
                            v-for="(column, index) in collection.columns"
                            :key="index"
                            v-text="$t('table.' + column)"
                        />
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-t border-gray-100 hover:bg-blue-50 focus-within:bg-blue-50"
                        v-for="(row, rowIndex) in collection.data"
                        :key="rowIndex"
                    >
                        <td
                            v-for="(column, columnIndex) in collection.columns"
                            :key="columnIndex"
                        >
                            <inertia-link
                                class="block px-6 py-4 focus:outline-none"
                                :href="
                                    $route(route, collection.data[rowIndex].id)
                                "
                                :tabindex="columnIndex === 0 ? false : -1"
                            >
                                {{ collection.data[rowIndex][column] }}
                            </inertia-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination v-if="paginate" class="mt-4" :links="collection.links" />
    </div>
</template>

<script>
    import Pagination from '@/Shared/Pagination';

    export default {
        components: {
            Pagination,
        },
        props: {
            collection: {
                type: Object,
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
