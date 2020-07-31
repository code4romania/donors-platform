<template>
    <component
        :is="external ? 'a' : 'inertia-link'"
        :href="href"
        class="flex items-center px-2 py-2 font-semibold leading-tight transition duration-150 ease-in-out rounded-sm group focus:outline-none"
        :class="style"
    >
        <svg-vue
            v-if="icon"
            :icon="icon"
            class="w-6 h-6 p-0.5 mr-2 text-gray-300 transition duration-150 ease-in-out fill-current group-hover:text-gray-300 group-focus:text-gray-300"
        />
        {{ label }}
    </component>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                required: true,
            },
            href: {
                type: String,
                required: true,
            },
            icon: {
                type: [String, null],
                default: null,
            },
            external: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            isCurrentUrl() {
                return this.href === location.origin + location.pathname;
            },
            style() {
                if (!this.external && this.isCurrentUrl) {
                    return 'text-white bg-gray-900 focus:bg-gray-700';
                } else {
                    return 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700';
                }
            },
        },
    };
</script>
