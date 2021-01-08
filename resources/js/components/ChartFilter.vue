<template>
    <grid class="sm:grid-cols-3 xl:grid-cols-2">
        <div class="w-full sm:w-auto">
            <form-button
                type="button"
                color="blue"
                shade="light"
                class="text-sm truncate"
                @click="$emit('reset')"
                v-text="$t('dashboard.action.reset')"
            />
        </div>

        <grid class="sm:col-span-2 sm:grid-cols-2 xl:col-span-1">
            <slot />
        </grid>
    </grid>
</template>

<script>
    export default {
        name: 'ChartFilter',
    };
</script>
