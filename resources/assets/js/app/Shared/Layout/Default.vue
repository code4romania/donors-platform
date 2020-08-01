<template>
    <div class="flex h-screen overflow-hidden">
        <portal-target name="menu-mobile-backdrop" slim />

        <main-menu :url="url" />

        <div class="relative z-0 flex flex-col flex-1 focus:outline-none">
            <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow">
                <portal-target name="menu-mobile-button" slim />
                <div class="flex items-center justify-end flex-1 px-4">
                    <div class="flex items-center ml-4 lg:ml-6">
                        <notifications />

                        <profile />
                    </div>
                </div>
            </div>
            <main class="flex-1 overflow-y-auto scrolling-touch" scroll-region>
                <div class="grid row-gap-6 px-4 py-8 md:p-12">
                    <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">
                        <slot name="title" />
                    </h1>

                    <div
                        v-if="$slots.actions"
                        class="flex justify-end space-x-4"
                    >
                        <slot name="actions" />
                    </div>

                    <slot />
                </div>
            </main>

            <flash-messages />
        </div>
    </div>
</template>

<script>
    import MainMenu from '@/Shared/Menu/Main';
    import FlashMessages from '@/Shared/FlashMessages';
    import Notifications from '@/Shared/Notifications';
    import Profile from '@/Shared/Profile';

    export default {
        components: {
            MainMenu,
            FlashMessages,
            Notifications,
            Profile,
        },
        computed: {
            url: () => location.origin + location.pathname,
        },
    };
</script>
