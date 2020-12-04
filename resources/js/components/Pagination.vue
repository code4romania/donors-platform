<template>
    <div
        v-if="hasPages"
        class="flex items-center justify-between py-4 leading-tight"
    >
        <div class="flex justify-start flex-1 w-0">
            <inertia-link
                v-if="prevPage !== null"
                :class="[baseStyle, hoverStyle]"
                :href="prevPage"
                v-text="$t('pagination.prev')"
            />
        </div>

        <nav class="hidden space-x-1 md:flex">
            <template v-for="(page, index) in pages">
                <inertia-link
                    v-if="page.url !== null"
                    :key="index"
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
                    :key="index"
                    :class="baseStyle"
                    v-text="page.label"
                />
            </template>
        </nav>

        <div class="flex justify-end flex-1 w-0">
            <inertia-link
                v-if="nextPage !== null"
                :class="[baseStyle, hoverStyle]"
                :href="nextPage"
                v-text="$t('pagination.next')"
            />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Pagination',
        props: {
            meta: {
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
                if (this.meta.total === 0) {
                    return false;
                }

                if (this.meta.total <= this.meta.per_page) {
                    return false;
                }

                return true;
            },
            pages() {
                return this.pagination(
                    this.meta.current_page,
                    this.meta.last_page
                ).map((page) => {
                    if (page === '...') {
                        return {
                            url: null,
                            label: page,
                            active: false,
                        };
                    } else {
                        return {
                            url: this.pageUrl(page),
                            label: page,
                            active: page === this.meta.current_page,
                        };
                    }
                });
            },
            prevPage() {
                if (this.meta.current_page - 1 >= 1) {
                    return this.pageUrl(this.meta.current_page - 1);
                }

                return null;
            },
            nextPage() {
                if (this.meta.current_page + 1 <= this.meta.last_page) {
                    return this.pageUrl(this.meta.current_page + 1);
                }

                return null;
            },
        },
        methods: {
            pageUrl(page) {
                let params = new URLSearchParams(location.search);

                params.set('page', page);

                return this.meta.path + '?' + params.toString();
            },
            separate(a, b) {
                return [
                    a,
                    ...({
                        0: [],
                        1: [b],
                    }[b - a] || ['...', b]),
                ];
            },
            pagination(currentPage, pageCount) {
                return Array(this.maxVisibleButtons * 2 + 1)
                    .fill()
                    .map((_, index) => currentPage - this.maxVisibleButtons + index)
                    .filter((page) => 0 < page && page <= pageCount)
                    .flatMap((page, index, { length }) => {
                        if (!index) {
                            return this.separate(1, page);
                        }

                        if (index === length - 1) {
                            return this.separate(page, pageCount);
                        }

                        return [page];
                    });
            },
        },
    };
</script>
