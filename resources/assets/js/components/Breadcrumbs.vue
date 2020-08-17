<template>
    <div>
        <template v-for="(item, index) in items">
            <component
                :is="component(item)"
                :key="index"
                :href="href(item)"
                :class="style(item)"
                v-text="item.label"
            />

            <span
                v-if="index + 1 < items.length"
                :key="`divider-${index}`"
                class="font-normal text-gray-300"
                aria-hidden="true"
            >
                {{ divider }}
            </span>
        </template>
    </div>
</template>

<script>
    export default {
        name: 'Breadcrumbs',
        props: {
            items: {
                type: Array,
                required: true,
            },
            divider: {
                type: String,
                default: '//',
            },
        },
        methods: {
            isLinkable(item) {
                return item.hasOwnProperty('href') && item.href;
            },
            component(item) {
                return this.isLinkable(item) ? 'inertia-link' : 'span';
            },
            href(item) {
                if (!this.isLinkable(item)) {
                    return null;
                }

                return item.href;
            },
            style(item) {
                if (!this.isLinkable(item)) {
                    return null;
                }

                return 'text-blue-500 hover:text-blue-600';
            },
        },
    };
</script>
