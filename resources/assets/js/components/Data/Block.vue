<template>
    <div class="min-w-0">
        <div v-if="canChangeView" class="flex p-4 space-x-5">
            <template v-for="view in views">
                <button
                    :key="view.name"
                    class="inline-flex items-center transition duration-150 focus:outline-none"
                    :class="
                        currentView !== view.name
                            ? 'opacity-50 hover:opacity-100'
                            : ''
                    "
                    @click="changeView(view.name)"
                >
                    <svg-vue
                        :icon="view.icon"
                        class="w-5 h-5 mr-2 text-blue-600 fill-current"
                    />
                    <span v-text="$t(`dashboard.view.${view.name}`)" />
                </button>
            </template>
        </div>

        <slot name="table" v-if="isCurrentView('table')" />

        <div v-if="isCurrentView('chart')" class="space-y-6">
            <slot name="filters" />

            <div class="relative px-4 py-5 bg-white rounded shadow sm:p-6">
                <slot name="chart">
                    <bar-chart :id="id" :options="options" :series="series" />
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
    import isEmpty from 'lodash/isEmpty';
    import merge from 'lodash/merge';

    export default {
        name: 'DataBlock',
        props: {
            id: {
                type: [String, null],
                default: null,
            },
            series: {
                type: Array,
                default: () => [],
            },
            options: {
                type: Object,
                default: () => ({}),
            },
        },
        data() {
            return {
                currentView: this.hasTable() ? 'table' : 'chart',
                views: [
                    {
                        name: 'table',
                        icon: 'Design/grid-line',
                    },
                    {
                        name: 'chart',
                        icon: 'Business/line-chart-line',
                    },
                ],
            };
        },
        computed: {
            canChangeView() {
                return this.hasTable() && this.hasChart();
            },
        },
        methods: {
            hasTable() {
                return this.$slots.hasOwnProperty('table');
            },
            hasChart() {
                return !isEmpty(this.chartData);
            },
            isCurrentView(name) {
                return this.currentView === name;
            },
            changeView(name) {
                this.currentView = name;
            },
        },
    };
</script>
