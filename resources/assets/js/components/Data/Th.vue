<template>
    <th>
        <div class="flex justify-between">
            <span v-text="column.label" />
            <button
                v-if="column.sortable"
                @click="orderBy(column)"
                class="duration-150 transition-color focus:outline-none focus:text-blue-600"
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
            </button>
        </div>
    </th>
</template>

<script>
    export default {
        name: 'DataTableHead',
        props: {
            column: {
                type: Object,
                required: true,
            },
            value: {
                type: Object,
            },
        },
        data() {
            return {
                order: null,
                direction: 'asc',
            };
        },
        computed: {
            alternativeSortData() {
                return {
                    order: this.column.field,
                    direction: this.isOrderAsc ? 'desc' : 'asc',
                };
            },
            isActive() {
                return this.value.order === this.column.field;
            },
            isOrderAsc() {
                return this.isActive && this.value.direction === 'asc';
            },
            isOrderDesc() {
                return !this.isOrderAsc;
            },
            iconClass() {
                return 'w-5 h-5 fill-current';
            },
        },
        methods: {
            orderBy(column) {
                this.$emit('input', this.alternativeSortData);
            },
        },
    };
</script>
