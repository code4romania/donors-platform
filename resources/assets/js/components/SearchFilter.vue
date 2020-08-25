<template>
    <div class="flex items-center max-w-lg">
        <div class="flex w-full bg-white rounded shadow">
            <dropdown
                v-if="hasFilters"
                button-class="flex items-center px-3 py-3 border-r md:px-6 focus:outline-none hover:bg-gray-100 focus:bg-blue-100"
                placement="bottom-start"
                aria-labelledby="filter-dropdown"
            >
                <span
                    id="filter-dropdown"
                    class="sr-only md:inline-block md:not-sr-only md:mr-2"
                    v-text="$t('dashboard.action.filter')"
                />

                <svg-vue
                    icon="System/filter-3-line"
                    class="w-5 h-6 text-gray-700 rounded-full fill-current"
                />

                <div
                    slot="dropdown"
                    class="grid w-screen max-w-xs px-4 py-6 gap-y-4"
                >
                    <slot />
                </div>
            </dropdown>

            <div class="relative flex-1 w-full">
                <label
                    for="search"
                    class="sr-only"
                    v-text="$t('dashboard.action.search')"
                />

                <input
                    id="search"
                    class="w-full px-6 py-3 pr-10 rounded-r focus:outline-none"
                    autocomplete="off"
                    type="text"
                    name="search"
                    :placeholder="$t('dashboard.action.search') + '…'"
                    v-model="search"
                />
                <button
                    v-if="search"
                    class="absolute inset-y-0 rounded-full focus:outline-none focus:shadow-outline m-auto w-5 h-5 text-gray-300 right-2.5"
                    @click="search = null"
                >
                    <svg-vue
                        icon="System/close-circle-fill"
                        class="w-full h-full fill-current"
                    />
                </button>
            </div>
        </div>

        <button
            type="button"
            class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-blue-500 focus:outline-none"
            @click="$emit('reset')"
            v-text="$t('dashboard.action.reset')"
        />
    </div>
</template>

<script>
    export default {
        name: 'SearchFilter',
        props: {
            value: {
                type: [String, null],
                default: null,
            },
        },
        data() {
            return {
                search: this.value,
            };
        },
        computed: {
            hasFilters() {
                return Boolean(this.$slots.default);
            },
            hasSearchTerm() {
                return Boolean(this.search);
            },
        },
        methods: {
            reset() {
                this.search = null;
            },
        },
        watch: {
            value: {
                immediate: true,
                handler(newValue) {
                    this.search = newValue;
                },
            },
            search(newValue) {
                this.$emit('input', newValue);
            },
        },
    };
</script>
