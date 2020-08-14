<template>
    <div
        class="min-w-0 overflow-hidden bg-white rounded-sm shadow sm:rounded-lg md:shadow-md"
    >
        <div class="flex p-4 space-x-5">
            <button
                v-for="view in views"
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
        </div>

        <data-table
            v-if="isCurrentView('table')"
            :data="data"
            :columns="columns"
        />
        <bar-chart
            v-if="isCurrentView('graph')"
            class="relative max-h-screen px-4 py-5 sm:p-6"
            :chart-data="chartData"
        />
    </div>
</template>

<script>
    export default {
        name: 'DataBlock',
        props: {
            data: {
                type: Array,
                required: true,
            },
            columns: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                currentView: 'table',
                views: [
                    {
                        name: 'table',
                        icon: 'Design/grid-line',
                    },
                    {
                        name: 'graph',
                        icon: 'Business/line-chart-line',
                    },
                ],
                chartData: {
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
                },
            };
        },
        computed: {},
        methods: {
            isCurrentView(name) {
                return this.currentView === name;
            },
            changeView(name) {
                this.currentView = name;
            },
        },
    };
</script>
