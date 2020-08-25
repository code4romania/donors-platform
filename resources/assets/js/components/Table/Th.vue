<template>
    <th>
        <div class="flex justify-between">
            <span v-text="label" />
            <inertia-link
                v-if="column.sortable"
                :href="$route($page.route)"
                :data="linkData"
                class="duration-150 transition-color hover:text-gray-600"
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
        },
        computed: {
            linkData() {
                const filters = pickBy(
                    merge(this.$page.filters, { search: this.$page.search })
                );

                if (this.isOrderAsc) {
                    return {
                        order: this.column.name,
                        direction: 'desc',
                        ...filters,
                    };
                } else if (this.isOrderDesc) {
                    return {
                        ...filters,
                    };
                } else {
                    return {
                        order: this.column.name,
                        direction: 'asc',
                        ...filters,
                    };
                }
            },
            label() {
                return this.$t('field.' + this.column.name);
            },
            isActive() {
                return this.$page.sort.order === this.column.name;
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
