<template>
    <div class="relative ml-3" v-click-away="close">
        <div>
            <button
                @click="toggle"
                class="flex items-center max-w-xs p-2 text-sm rounded-full hover:bg-gray-100 focus:outline-none focus:shadow-outline"
                aria-label="User menu"
                aria-haspopup="true"
            >
                <svg-vue
                    icon="User/user-line"
                    class="w-5 h-5 rounded-full fill-current"
                />
            </button>
        </div>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="open"
                class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg"
            >
                <nav class="py-1 bg-white rounded-md shadow-xs">
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
                        role="menuitem"
                        >Your Profile</a
                    >
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
                        role="menuitem"
                        >Settings</a
                    >

                    <inertia-link
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
                        :href="$route('logout')"
                        method="post"
                        >Logout</inertia-link
                    >
                </nav>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'Profile',
        data() {
            return {
                open: false,
            };
        },
        methods: {
            toggle() {
                this.open = !this.open;
            },
            close() {
                this.open = false;
            },
        },
    };
</script>
