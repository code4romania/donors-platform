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

        <div
            class="relative max-h-screen px-4 py-5 bg-white rounded shadow sm:p-6"
            v-if="isCurrentView('chart')"
        >
            <slot name="chart">
                <bar-chart
                    v-if="chartData && isCurrentView('chart')"
                    :chart-data="chartData"
                    :chart-options="chartOptions"
                />
            </slot>
        </div>
    </div>
</template>

<script>
    import isEmpty from 'lodash/isEmpty';

    export default {
        name: 'DataBlock',
        props: {
            chartData: {
                type: Object,
                default: () => ({
                    labels: [
                        'Category 1',
                        'Category 2',
                        'Category 3',
                        'Category 4',
                        'Category 5',
                    ],
                    datasets: [
                        {
                            label: 'Dataset 1',
                            data: [12, 19, 3, 5, 2],
                        },
                        {
                            label: 'Dataset 2',
                            data: [1, 4, 15, 32, 23],
                        },
                        {
                            label: 'Dataset 3',
                            data: [12, 3, 5, 2, 3],
                        },
                    ],
                }),
            },
            chartOptions: {
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
