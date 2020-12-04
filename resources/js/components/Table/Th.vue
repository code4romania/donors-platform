<template>
    <th :class="thStyles">
        <component
            :is="thComponent"
            class="flex justify-between px-6 py-4 group"
            :href="computedRoute"
            :data="nextSortOrder"
        >
            <span v-text="column.label" />

            <template v-if="column.sortable">
                <svg-vue
                    v-if="isOrderAsc || !$page.props.sort.order"
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
    import identity from 'lodash/identity';

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
                    return this.$route(this.$page.props.route);
                }

                return this.route;
            },
            nextSortOrder() {
                if (!this.isSortable) {
                    return false;
                }

                const filters = pickBy(
                    {
                        search: this.$page.props.search,
                        filters: this.$page.props.filters,
                    },
                    identity
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
                return this.$page.props.sort.order === this.field;
            },
            isOrderAsc() {
                return this.$page.props.sort.direction === 'asc';
            },
            isOrderDesc() {
                return this.$page.props.sort.direction === 'desc';
            },
            iconClass() {
                return (
                    'w-5 h-5 -mr-0.5 ml-2 fill-current duration-150 cursor-pointer transition-color group-focus:outline-none group-focus:text-blue-600 group-hover:text-blue-500 ' +
                    (this.isActive ? 'text-gray-900' : 'text-gray-300')
                );
            },
            isShrinkableColumn() {
                if (
                    this.column.field.match(
                        /(amount|_(date|funding|count|status))/i
                    )
                ) {
                    return true;
                }

                return false;
            },
            thStyles() {
                return this.isShrinkableColumn ? 'w-1 whitespace-no-wrap' : false;
            },
        },
    };
</script>
