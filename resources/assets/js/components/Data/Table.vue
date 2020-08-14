<template>
    <div class="leading-tight text-gray-900">
        <div class="max-w-full overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="font-semibold leading-tight text-left">
                        <th
                            class="px-6 py-4"
                            v-for="(column, index) in columns"
                            :key="index"
                        >
                            {{ column }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-t border-gray-100"
                        :class="rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                        v-for="(row, rowIndex) in data"
                        :key="rowIndex"
                    >
                        <td
                            class="px-6 py-4"
                            v-for="(column, columnIndex) in columns"
                            :key="columnIndex"
                        >
                            <slot :name="column" :[column]="row[column]">
                                {{ row[column] }}
                            </slot>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DataTable',
        props: {
            data: {
                type: Array,
                required: true,
            },
            columns: {
                type: Array,
                required: true,
            },
        },
    };
</script>
