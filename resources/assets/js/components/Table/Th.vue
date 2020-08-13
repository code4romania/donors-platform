<template>
    <th>
        <div class="flex justify-between">
            <span v-text="label" />
            <inertia-link
                v-if="column.sortable"
                :href="$route($page.route)"
                :data="alternativeSortData"
                class="duration-150 transition-color"
                :class="{
                    'text-gray-300 hover:text-gray-600': !isActive,
                    'text-gray-900 hover:text-gray-600': isActive,
                }"
            >
                <svg-vue
                    v-show="isOrderAsc"
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
    export default {
        name: 'TableHead',
        props: {
            column: {
                type: Object,
                required: true,
            },
        },
        computed: {
            alternativeSortData() {
                return {
                    order: this.column.name,
                    direction: this.isOrderAsc ? 'desc' : 'asc',
                };
            },
            label() {
                return this.$t('dashboard.field.' + this.column.name);
            },
            isActive() {
                return this.$page.sort.order === this.column.name;
            },
            isOrderAsc() {
                return this.$page.sort.direction === 'asc';
            },
            isOrderDesc() {
                return !this.isOrderAsc;
            },
            iconClass() {
                return 'w-5 h-5 fill-current';
            },
        },
    };
</script>
