<template>
    <div class="overflow-hidden bg-white rounded shadow">
        <div
            v-if="title || icon"
            class="flex items-center p-4"
            :class="headerClass"
        >
            <svg-vue
                v-if="icon"
                :icon="icon"
                class="w-5 h-5 mr-2 fill-current"
            />
            <h2 class="text-lg font-semibold tracking-wide" v-text="title" />
        </div>
        <div class="px-4 py-5 sm:p-6">
            <slot />
        </div>
        <div
            v-if="$slots.footer"
            class="p-4 text-sm leading-tight bg-gray-50 sm:p-6"
        >
            <slot name="footer" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Panel',
        props: {
            headerClass: {
                type: String,
                default: 'shadow-xs',
            },
            icon: {
                type: [String, null],
                default: null,
            },
            title: {
                type: [String, null],
                default: null,
            },
        },
    };
</script>
