<template>
    <grid class="items-center grid-cols-1 md:grid-cols-3">
        <div>
            <form-label id="search" :label="$t('dashboard.action.search')" />

            <div
                class="relative overflow-hidden bg-white border border-gray-300 form-input"
            >
                <input
                    id="search"
                    class="w-full pr-10 rounded-r focus:outline-none"
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

        <div v-if="hasFilters" class="md:col-span-2">
            <grid :class="filterClass">
                <slot />
            </grid>
        </div>

        <div v-if="hasFilters" class="flex md:col-span-3">
            <form-button
                type="button"
                color="blue"
                shade="light"
                class="text-sm"
                @click="$emit('reset')"
                v-text="$t('dashboard.action.reset')"
            />
        </div>
    </grid>
</template>

<script>
    export default {
        name: 'SearchFilter',
        props: {
            value: {
                type: [String, null],
                default: null,
            },
            filterClass: {
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
