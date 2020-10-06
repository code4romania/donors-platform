<template>
    <div class="min-w-0 leading-tight text-gray-900">
        <pagination v-if="paginate" class="mb-4" :meta="collection.meta" />

        <base-table
            :columns="columns"
            :data="collection.data"
            :route-name="routeName"
            :route-args="routeArgs"
            :route-fill="routeFill"
            :sort-args="sortArgs"
        >
            <template
                v-for="(_, name) in $scopedSlots"
                :slot="name"
                slot-scope="slotData"
            >
                <slot :name="name" v-bind="slotData" />
            </template>
        </base-table>

        <pagination v-if="paginate" class="mt-4" :meta="collection.meta" />
    </div>
</template>

<script>
    import cloneDeep from 'lodash/cloneDeep';
    import isEmpty from 'lodash/isEmpty';
    import mapValues from 'lodash/mapValues';
    import merge from 'lodash/merge';

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
            paginate: {
                type: Boolean,
                default: true,
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
