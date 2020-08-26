<template>
    <th>
        <div class="flex justify-between">
            <span v-text="column.label" />
            <inertia-link
                v-if="column.sortable"
                :href="computedRoute"
                :data="linkData"
                class="duration-150 cursor-pointer transition-color focus:outline-none focus:text-blue-600 hover:text-gray-600"
                :class="{
                    'text-gray-300': !isActive,
                    'text-gray-900': isActive,
                }"
            >
                <svg-vue
                    v-show="isOrderAsc || !$page.sort.order"
                    icon="Editor/sort-asc"
                    :class="iconClass"
                />

                <svg-vue
                    v-show="isOrderDesc"
                    icon="Editor/sort-desc"
                    :class="iconClass"
                />
            </inertia-link>
        </div>
    </th>
</template>

<script>
    import merge from 'lodash/merge';
    import pickBy from 'lodash/pickBy';

    export default {
        name: 'TableHead',
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
            field() {
                return this.column.field.replace('___', '.');
            },
            computedRoute() {
                if (!this.route) {
                    return this.$route(this.$page.route);
                }

                return this.route;
            },
            linkData() {
                const filters = pickBy(
                    merge(this.$page.filters, { search: this.$page.search })
                );

                if (this.isOrderAsc) {
                    return {
                        order: this.field,
                        direction: 'desc',
                        ...filters,
                    };
                } else if (this.isOrderDesc) {
                    return {
                        ...filters,
                    };
                } else {
                    return {
                        order: this.field,
                        direction: 'asc',
                        ...filters,
                    };
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
                return 'w-5 h-5 fill-current';
            },
        },
    };
</script>
