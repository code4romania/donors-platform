<template>
    <th :class="maybeShrinkColumn">
        <component
            :is="thComponent"
            class="flex justify-between px-6 py-4 group"
            :href="computedRoute"
            :data="nextSortOrder"
        >
            <span v-text="column.label" />

            <template v-if="column.sortable">
                <svg-vue
                    v-if="isOrderAsc || !$page.sort.order"
                    icon="Editor/sort-asc"
                    :class="iconClass"
                />

                <svg-vue
                    v-if="isOrderDesc"
                    icon="Editor/sort-desc"
                    :class="iconClass"
                />
            </template>
        </component>
    </th>
</template>

<script>
    import merge from 'lodash/merge';
    import pickBy from 'lodash/pickBy';

    export default {
        name: 'TableHead',
        inheritAttrs: false,
        props: {
            column: {
                type: Object,
                required: true,
            },
            route: {
                type: [String, null],
                default: null,
            },
        },
        computed: {
            thComponent() {
                return this.column.sortable ? 'inertia-link' : 'div';
            },
            isSortable() {
                return this.thComponent === 'inertia-link';
            },
            field() {
                return this.column.field.replace('___', '.');
            },
            computedRoute() {
                if (!this.isSortable) {
                    return false;
                }

                if (!this.route) {
                    return this.$route(this.$page.route);
                }

                return this.route;
            },
            nextSortOrder() {
                if (!this.isSortable) {
                    return false;
                }

                const filters = pickBy(
                    merge({ search: this.$page.search }, this.$page.filters)
                );

                if (!this.isActive) {
                    return {
                        order: this.field,
                        direction: 'asc',
                        ...filters,
                    };
                } else {
                    if (this.isOrderDesc) {
                        return {
                            ...filters,
                        };
                    } else {
                        return {
                            order: this.field,
                            direction: 'desc',
                            ...filters,
                        };
                    }
                }
            },
            isActive() {
                return this.$page.sort.order === this.field;
            },
            isOrderAsc() {
                return this.$page.sort.direction === 'asc';
            },
            isOrderDesc() {
                return this.$page.sort.direction === 'desc';
            },
            iconClass() {
                return (
                    'w-5 h-5 -mr-0.5 ml-2 fill-current duration-150 cursor-pointer transition-color group-focus:outline-none group-focus:text-blue-600 group-hover:text-blue-500 ' +
                    (this.isActive ? 'text-gray-900' : 'text-gray-300')
                );
            },
            maybeShrinkColumn() {
                let shrinkableColumns = [
                    'published_status',

                    'start_date',
                    'end_date',

                    'amount',
                    'regranting_amount',
                    'total_funding',

                    'project_count',
                ];

                return shrinkableColumns.includes(this.column.field)
                    ? 'w-1 whitespace-no-wrap'
                    : false;
            },
        },
    };
</script>
