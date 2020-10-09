<template>
    <dropdown
        button-class="flex items-center max-w-xs overflow-hidden text-sm text-gray-900 rounded group focus:outline-none focus:shadow-none"
    >
        <div class="flex items-center">
            <div class="text-right">
                <div class="text-sm font-semibold" v-text="$page.auth.name" />
                <div
                    class="w-48 text-xs text-gray-600 truncate"
                    v-text="$page.auth.organization.name"
                />
            </div>

            <svg-vue
                icon="User/user-line"
                class="w-10 h-10 p-2 ml-2 rounded-full fill-current group-hover:bg-gray-100 group-focus:bg-gray-100"
            />
        </div>

        <nav slot="dropdown" class="w-48">
            <inertia-link
                class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                v-for="(item, index) in items"
                :method="item.method || 'get'"
                v-text="item.label"
                :href="item.href"
                :key="index"
            />

            <form method="POST" @submit.prevent="logout">
                <button
                    class="block w-full px-4 py-2 text-sm text-left text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                    v-text="$t('auth.logout')"
                />
            </form>
        </nav>
    </dropdown>
</template>

<script>
    export default {
        name: 'Profile',
        data() {
            return {
                items: [
                    // {
                    //     href: this.$route('logout'),
                    //     label: this.$t('auth.logout'),
                    //     method: 'post',
                    // },
                ],
            };
        },
        methods: {
            logout() {
                this.$inertia.post(this.$route('logout'));
            },
        },
    };
</script>
