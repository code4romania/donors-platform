<template>
    <grid class="md:grid-cols-4 xl:grid-cols-2">
        <div class="w-full md:w-auto">
            <form-button
                type="button"
                color="blue"
                shade="light"
                class="text-sm truncate"
                @click="$emit('reset')"
                v-text="$t('dashboard.action.reset')"
            />
        </div>

        <grid class="md:col-span-3 md:grid-cols-3 xl:col-span-1">
            <slot />
        </grid>
    </grid>
</template>

<script>
    export default {
        name: 'ChartFilter',
        props: {
            filterClass: {
                type: [String, null],
                default: null,
            },
        },
    };
</script>
