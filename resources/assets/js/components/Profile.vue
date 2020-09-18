<template>
    <dropdown
        button-class="flex items-center max-w-xs p-2 overflow-hidden text-sm text-gray-900 rounded-full hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
    >
        <svg-vue
            icon="User/user-line"
            class="w-5 h-5 rounded-full fill-current"
        />

        <nav slot="dropdown" class="w-48">
            <inertia-link
                class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
                v-for="(item, index) in items"
                :method="item.method || 'get'"
                v-text="item.label"
                :href="item.href"
                :key="index"
            />
        </nav>
    </dropdown>
</template>

<script>
    export default {
        name: 'Profile',
        data() {
            return {
                items: [
                    {
                        href: this.$route('logout'),
                        label: this.$t('dashboard.menu.settings'),
                    },
                    {
                        href: this.$route('logout'),
                        label: this.$t('auth.logout'),
                        method: 'post',
                    },
                ],
            };
        },
    };
</script>
