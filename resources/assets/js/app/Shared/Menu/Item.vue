<template>
    <div class="text-sm leading-tight">
        <component
            :is="external ? 'a' : 'inertia-link'"
            :href="href"
            class="flex items-center px-2 py-2 transition duration-150 ease-in-out rounded-sm group focus:outline-none"
            :class="style(this)"
        >
            <svg-vue
                v-if="icon"
                :icon="icon"
                class="w-5 h-5 p-0.5 mr-2 text-gray-300 transition duration-150 ease-in-out fill-current group-hover:text-gray-300 group-focus:text-gray-300"
            />
            {{ label }}
        </component>

        <div v-if="isCurrentSection && children.length" class="mt-1 mb-3">
            <component
                v-for="(item, index) in children"
                :key="index"
                :is="item.external ? 'a' : 'inertia-link'"
                :href="item.href"
                class="flex items-center py-2 pl-12 pr-2 transition duration-150 ease-in-out rounded-sm group focus:outline-none"
                :class="style(item)"
            >
                {{ item.label }}
            </component>
        </div>
    </div>
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
            children: {
                type: Array,
                default: () => [],
            },
        },
        computed: {
            isCurrentSection() {
                let currentUrl = location.origin + location.pathname;

                return (
                    this.href === currentUrl ||
                    this.children.filter((i) => currentUrl === i.href).length > 0
                );
            },
        },
        methods: {
            isCurrentUrl(href) {
                return href === location.origin + location.pathname;
            },
            style(item) {
                if (!item.external && this.isCurrentUrl(item.href)) {
                    return 'text-white bg-gray-900 focus:bg-gray-700';
                } else {
                    return 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700';
                }
            },
        },
    };
</script>
