<template>
    <div class="flex h-screen overflow-hidden">
        <portal-target name="menu-mobile-backdrop" slim />

        <main-menu :url="url" />

        <main class="relative z-0 flex-1 overflow-y-auto focus:outline-none">
            <div class="relative z-10 flex flex-shrink-0 h-16 bg-white shadow">
                <portal-target name="menu-mobile-button" slim />
                <div class="flex items-center justify-end flex-1 px-4">
                    <div class="flex items-center ml-4 lg:ml-6">
                        <notifications />

                        <profile />
                    </div>
                </div>
            </div>
            <div class="grid row-gap-8 px-4 pt-2 pb-6 lg:p-6 lg:px-8">
                <div class="grid gap-8 md:grid-cols-2">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        <slot name="title" />
                    </h1>

                    <div class="flex justify-end space-x-4">
                        <slot name="actions" />
                    </div>
                </div>

                <slot />
            </div>
        </main>
    </div>
</template>

<script>
    import MainMenu from '@/Shared/Menu/Main';
    import Notifications from '@/Shared/Notifications';
    import Profile from '@/Shared/Profile';

    export default {
        components: {
            MainMenu,
            Notifications,
            Profile,
        },
        computed: {
            url: () => location.origin + location.pathname,
        },
    };
</script>
