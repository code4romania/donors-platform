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
                v-if="collection.links[key] !== null"
                :key="key"
                :class="[
                    baseStyle,
                    hoverStyle,
                    key === 'prev' ? 'order-1' : 'order-3',
                ]"
                :href="collection.links[key]"
                v-text="$t(`pagination.${key}`)"
            />
        </div>

        <nav class="order-2 hidden space-x-1 md:flex">
            <template v-for="page in pages">
                <inertia-link
                    v-if="page.url !== null"
                    :key="page.label"
                    :class="[
                        baseStyle,
                        hoverStyle,
                        page.active ? 'bg-white' : '',
                    ]"
                    :href="page.url"
                    v-text="page.label"
                />
                <span
                    v-else
                    :key="page.label"
                    :class="baseStyle"
                    v-text="page.label"
                />
            </template>
        </nav>
    </div>
</template>

<script>
    export default {
        props: {
            collection: {
                type: Object,
                required: true,
            },
            maxVisibleButtons: {
                type: Number,
                required: false,
                default: 3,
            },
        },
        computed: {
            baseStyle() {
                return 'px-4 py-3 border text-sm border-gray-200 rounded';
            },
            hoverStyle() {
                return 'hover:bg-white focus:border-blue-500 focus:text-blue-500 focus:outline-none';
            },

            hasPages() {
                if (this.collection.meta.total === 0) {
                    return false;
                }

                if (this.collection.meta.total <= this.collection.meta.per_page) {
                    return false;
                }

                return true;
            },
            pages() {
                return this.pagination(
                    this.collection.meta.current_page,
                    this.collection.meta.last_page
                ).map((page) => {
                    if (page === '...') {
                        return {
                            url: null,
                            label: page,
                            active: false,
                        };
                    } else {
                        return {
                            url: this.collection.meta.path + `?page=${page}`,
                            label: page,
                            active: page === this.collection.meta.current_page,
                        };
                    }
                });
            },
        },
        methods: {
            pagination(currentPage, pageCount, delta = 3) {
                const separate = (a, b) => [
                    a,
                    ...({
                        0: [],
                        1: [b],
                    }[b - a] || ['...', b]),
                ];

                return Array(delta * 2 + 1)
                    .fill()
                    .map((_, index) => currentPage - delta + index)
                    .filter((page) => 0 < page && page <= pageCount)
                    .flatMap((page, index, { length }) => {
                        if (!index) return separate(1, page);
                        if (index === length - 1) return separate(page, pageCount);

                        return [page];
                    });
            },
        },
    };
</script>
