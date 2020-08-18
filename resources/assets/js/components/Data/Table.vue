<template>
    <div class="leading-tight text-gray-900">
        <div class="max-w-full overflow-x-auto bg-white rounded shadow">
            <table class="w-full">
                <thead>
                    <tr class="font-semibold leading-tight text-left">
                        <data-table-head
                            class="px-6 py-4"
                            v-for="(column, index) in columns"
                            :key="index"
                            :column="column"
                            v-model="sort"
                        />
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="border-t border-gray-100"
                        :class="[
                            rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50',
                            rowClass,
                        ]"
                        v-for="(row, rowIndex) in orderedData"
                        :key="rowIndex"
                    >
                        <td
                            v-for="(column, columnIndex) in columns"
                            :key="columnIndex"
                        >
                            <component
                                :is="componentType"
                                :href="componentHref(row.id)"
                                class="block px-6 py-4 focus:outline-none"
                            >
                                <slot
                                    :name="column.field"
                                    :[column.field]="row[column.field]"
                                >
                                    {{ row[column.field] }}
                                </slot>
                            </component>
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
            routeName: {
                type: [String, null],
                default: null,
            },
            routeArgs: {
                type: Object,
                default: () => ({}),
            },
            routeFill: {
                type: Object,
                default: () => ({}),
            },
        },
        data() {
            return {
                sort: {
                    order: null,
                    direction: 'asc',
                },
            };
        },
        computed: {
            orderedData() {
                if (!this.sort.order || !this.sort.direction) {
                    return this.data;
                }

                let column = this.columns.find((c) => c.field === this.sort.order),
                    modifier = this.sort.direction === 'asc' ? 1 : -1,
                    options = {
                        numeric: column.sortable.numeric || false,
                    };

                if (column.sortable.prop) {
                    return this.data.sort((a, b) => {
                        return (
                            a[this.sort.order][column.sortable.prop].localeCompare(
                                b[this.sort.order][column.sortable.prop],
                                undefined,
                                options
                            ) * modifier
                        );
                    });
                }

                return this.data.sort((a, b) => {
                    return (
                        a[this.sort.order].localeCompare(
                            b[this.sort.order],
                            undefined,
                            options
                        ) * modifier
                    );
                });
            },
            isLinkable() {
                return this.routeName !== null;
            },
            rowClass() {
                return this.isLinkable
                    ? 'hover:bg-blue-50 focus-within:bg-blue-50'
                    : '';
            },
            componentType() {
                return this.isLinkable ? 'inertia-link' : 'div';
            },
        },
        methods: {
            componentHref(id) {
                let args = this.routeArgs;

                if (this.routeFill) {
                    Object.keys(this.routeFill).forEach((prop) => {
                        args[prop] = id;
                    });
                }

                return this.isLinkable ? this.$route(this.routeName, args) : false;
            },
        },
    };
</script>
