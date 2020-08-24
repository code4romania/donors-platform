<template>
    <dropdown
        button-class="flex items-center max-w-xs p-2 overflow-hidden text-sm rounded-full hover:bg-gray-100 focus:outline-none focus:shadow-outline"
    >
        <svg-vue
            icon="User/user-line"
            class="w-5 h-5 rounded-full fill-current"
        />

        <div slot="dropdown" class="w-48 mt-2 rounded-md shadow-lg">
            <nav class="py-1 whitespace-no-wrap bg-white rounded-md shadow-xs">
                <inertia-link
                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100"
                    v-for="(item, index) in items"
                    :method="item.method || 'get'"
                    v-text="item.label"
                    :href="item.href"
                    :key="index"
                />
            </nav>
        </div>
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
                        label: this.$t('dashboard.menu.logout'),
                        method: 'post',
                    },
                ],
            };
        },
    };
</script>
