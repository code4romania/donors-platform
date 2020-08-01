<template>
    <div
        v-if="hasPages"
        class="flex items-center justify-between py-4 leading-tight"
    >
        <div
            v-for="key in ['prev', 'next']"
            :key="key"
            class="flex flex-1 w-0"
            :class="{
                'order-1 justify-start': key === 'prev',
                'order-3 justify-end': key === 'next',
            }"
        >
            <inertia-link
                v-if="links[key].url !== null"
                :key="key"
                :class="[style, key === 'prev' ? 'order-1' : 'order-3']"
                :href="links[key].url"
                >{{ links[key].label }}</inertia-link
            >
        </div>

        <nav class="order-2 hidden space-x-1 md:flex">
            <inertia-link
                v-for="(page, key) in links.pages"
                :key="key"
                :href="page.url"
                v-text="page.label"
                :class="[style, page.active ? 'bg-white' : '']"
            />
        </nav>
    </div>
</template>

<script>
    export default {
        props: {
            links: {
                type: Object,
                required: true,
            },
        },
        computed: {
            style() {
                return 'px-4 py-3 border text-sm border-gray-200 rounded hover:bg-white focus:border-blue-500 focus:text-blue-500 focus:outline-none';
            },
            hasPages() {
                return this.links.pages.length > 1;
            },
        },
    };
</script>
