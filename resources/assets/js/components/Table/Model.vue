<template>
    <div class="leading-tight text-gray-900">
        <div class="max-w-full overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="font-semibold leading-tight text-left">
                        <table-head
                            class="px-6 py-4"
                            v-for="(column, index) in columns"
                            :key="index"
                            :column="column"
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
                            v-for="(column, columnIndex) in columns"
                            :key="columnIndex"
                        >
                            <inertia-link
                                class="block px-6 py-4 focus:outline-none"
                                :href="$route(route, row.id)"
                                :tabindex="columnIndex === 0 ? false : -1"
                            >
                                <slot
                                    :name="column.name"
                                    :[column.name]="row[column.name]"
                                >
                                    {{ row[column.name] }}
                                </slot>
                            </inertia-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination v-if="paginate" class="mt-4" :meta="collection.meta" />
    </div>
</template>

<script>
    export default {
        name: 'ModelTable',
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
