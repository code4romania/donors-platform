<template>
    <div class="flex h-screen overflow-hidden">
        <portal-target name="menu-mobile-backdrop" slim />

        <main-menu :url="url" />

        <div class="relative z-0 flex flex-col flex-1 focus:outline-none">
            <div
                class="relative z-10 flex flex-shrink-0 h-16 bg-white ring-1 ring-black ring-opacity-5"
            >
                <portal-target name="menu-mobile-button" slim />
                <div
                    class="flex items-center justify-end flex-1 px-4 space-x-6"
                >
                    <currency-select class="w-20" />
                </div>
            </div>
            <main
                class="flex-1 w-full overflow-y-auto scrolling-touch"
                scroll-region
            >
                <div class="grid w-full px-4 py-8 gap-y-6 md:p-8">
                    <div
                        class="flex -mb-6"
                        v-if="
                            $route('dashboard') !== url &&
                            $route('help') !== url
                        "
                    >
                        <button
                            class="inline-flex items-center text-sm text-gray-600 hover:text-blue-500 focus:outline-none focus:text-blue-600"
                            @click="goBack"
                        >
                            <svg-vue
                                icon="System/arrow-left-s-line"
                                class="w-4 h-4 mr-0.5 fill-current"
                            />

                            <span v-text="$t('dashboard.back')" />
                        </button>
                    </div>

                    <div
                        class="flex flex-wrap items-center space-y-6 md:flex-no-wrap md:space-y-0 md:space-x-6"
                    >
                        <h1
                            class="flex-1 w-full text-2xl font-bold text-gray-900 md:text-3xl md:w-auto"
                        >
                            <slot name="title">
                                <breadcrumbs
                                    v-if="breadcrumbs.length"
                                    :items="breadcrumbs"
                                />
                            </slot>
                        </h1>

                        <div
                            v-if="$slots.actions"
                            class="flex justify-end w-full space-x-4 md:w-auto"
                        >
                            <slot name="actions" />
                        </div>
                    </div>

                    <slot />
                </div>
            </main>

            <flash-messages />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Layout',
        computed: {
            url: () => location.origin + location.pathname,
        },
        props: {
            breadcrumbs: {
                type: Array,
                default: () => [],
            },
        },
        methods: {
            goBack() {
                history.back();
            },
        },
    };
</script>
