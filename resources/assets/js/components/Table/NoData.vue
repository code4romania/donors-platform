<template>
    <div
        v-if="show"
        class="flex flex-col items-center px-6 py-20 border-t border-gray-100"
    >
        <svg-vue
            icon="System/search-eye-line"
            class="w-10 h-10 text-gray-400 fill-current"
        />
        <span class="mt-4 text-lg text-gray-700">
            {{ $t('dashboard.table.empty') }}
        </span>
    </div>
</template>

<script>
    export default {
        name: 'TableNoData',
        props: {
            show: {
                type: Boolean,
                default: false,
            },
        },
    };
</script>
