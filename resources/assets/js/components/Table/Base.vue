<template>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full">
            <thead>
                <tr class="font-semibold leading-tight text-left">
                    <table-head
                        v-for="(column, index) in columns"
                        :key="index"
                        :column="column"
                        :route="thRoute"
                    />
                </tr>
            </thead>
            <tbody>
                <tr
                    class="border-t border-gray-100"
                    :class="
                        showRowUrls
                            ? 'hover:bg-blue-50 focus-within:bg-blue-50'
                            : ''
                    "
                    v-for="(row, rowIndex) in data"
                    :key="rowIndex"
                >
                    <td
                        v-for="(column, columnIndex) in columns"
                        :key="columnIndex"
                    >
                        <component
                            :is="showRowUrls ? 'inertia-link' : 'div'"
                            class="block px-6 py-4 focus:outline-none"
                            :href="showRowUrls ? rowUrl(row) : false"
                            :tabindex="
                                !showRowUrls || (columnIndex === 0 ? false : -1)
                            "
                        >
                            <slot
                                :name="column.field"
                                :[column.field]="row[column.field]"
                                :row="row"
                            >
                                {{ row[column.field] }}
                            </slot>
                        </component>
                    </td>
                </tr>
            </tbody>
        </table>

        <table-no-data :show="!data.length" />
    </div>
</template>

<script>
    import cloneDeep from 'lodash/cloneDeep';
    import isEmpty from 'lodash/isEmpty';
    import mapValues from 'lodash/mapValues';
    import merge from 'lodash/merge';

    export default {
        name: 'BaseTable',
        props: {
            columns: {
                type: Array,
                required: true,
            },
            data: {
                type: Array,
                required: true,
            },
            routeName: {
                type: String,
                required: true,
            },
            routeArgs: {
                type: Object,
                default: () => ({}),
            },
            sortArgs: {
                type: Object,
                default: () => ({}),
            },
            routeFill: {
                type: Object,
                default: () => ({}),
            },
            showRowUrls: {
                type: Boolean,
                default: true,
            },
        },
        computed: {
            thRoute() {
                return this.$route(
                    this.$page.route,
                    !isEmpty(this.sortArgs) ? this.sortArgs : this.routeArgs
                );
            },
        },
        methods: {
            rowUrl(row) {
                if (isEmpty(this.routeArgs)) {
                    return this.$route(this.routeName, row.id);
                }

                let args = cloneDeep(this.routeArgs);

                if (this.routeFill) {
                    Object.entries(this.routeFill).forEach(([key, prop]) => {
                        if (row.hasOwnProperty(prop)) {
                            args[key] = row[prop];
                        }
                    });
                }

                return this.$route(this.routeName, args);
            },
        },
    };
</script>
