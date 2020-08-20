<template>
    <div
        class="fixed inset-0 z-40 flex flex-shrink-0 w-64 lg:relative"
        :class="{ '-ml-64 lg:ml-0': !open }"
    >
        <portal to="menu-mobile-backdrop">
            <div
                @click="open = false"
                v-if="open"
                class="fixed inset-0"
                :class="{ 'z-40 lg:hidden': open }"
            >
                <div class="absolute inset-0 bg-gray-600 opacity-75" />
            </div>
        </portal>

        <portal to="menu-mobile-button">
            <button
                @click="open = true"
                class="px-4 text-gray-500 border-r border-gray-200 focus:outline-none focus:bg-gray-100 focus:text-gray-600 lg:hidden"
                aria-label="Open sidebar"
            >
                <svg-vue icon="System/menu-fill" class="w-6 h-6" />
            </button>
        </portal>

        <div class="flex flex-col flex-1">
            <div v-if="open" class="absolute top-0 p-2 left-full">
                <button
                    class="flex items-center justify-center w-12 h-12 rounded-full focus:outline-none focus:bg-gray-600"
                    aria-label="Close sidebar"
                    @click="open = false"
                >
                    <svg-vue
                        icon="System/close-fill"
                        class="w-6 h-6 text-white fill-current"
                    />
                </button>
            </div>
            <inertia-link
                :href="$route('dashboard.index')"
                class="flex items-center flex-shrink-0 h-16 px-4 transition-colors duration-150 bg-gray-900 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none"
            >
                <Logo class="w-full h-8 text-gray-200" />
            </inertia-link>

            <div
                class="flex flex-col flex-1 px-2 py-4 overflow-y-auto bg-gray-800"
            >
                <nav class="grid gap-y-1">
                    <template v-for="(item, index) in items">
                        <menu-item
                            v-if="showMenuItem(item)"
                            :icon="item.icon"
                            :href="item.href"
                            :label="item.label"
                            :children="item.children || []"
                            :key="index"
                        />
                    </template>

                    <hr class="my-4 border-gray-700" />

                    <menu-item
                        icon="System/logout-box-line"
                        :href="$route('home')"
                        :label="$t('dashboard.menu.back_to_site')"
                        :external="true"
                    />
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'MainMenu',
        props: {
            url: String,
        },
        data() {
            return {
                open: false,
                items: [
                    {
                        icon: 'System/dashboard-fill',
                        href: this.$route('dashboard.index'),
                        label: this.$t('dashboard.menu.dashboard'),
                    },
                    {
                        icon: 'Finance/money-euro-circle-line',
                        href: this.$route('donors.index'),
                        label: this.$t('model.donor.plural'),
                        children: [],
                    },
                    {
                        icon: 'Finance/money-euro-circle-line',
                        href: this.$route('managers.index'),
                        label: this.$t('model.manager.plural'),
                    },
                    {
                        icon: 'Design/focus-3-line',
                        href: this.$route('domains.index'),
                        label: this.$t('model.domain.plural'),
                    },
                    {
                        icon: 'Finance/funds-line',
                        href: this.$route('grants.index'),
                        label: this.$t('model.grant.plural'),
                    },
                    {
                        icon: 'Editor/organization-chart',
                        href: this.$route('grantees.index'),
                        label: this.$t('model.grantee.plural'),
                    },
                    {
                        icon: 'User/user-settings-line',
                        href: this.$route('users.index'),
                        label: this.$t('dashboard.menu.users'),
                        guard: 'manage users',
                    },
                ],
            };
        },
        methods: {
            isCurrentUrl(...urls) {
                return urls[0] === ''
                    ? this.url === ''
                    : urls.filter((url) => this.url.startsWith(url)).length > 0;
            },
            showMenuItem(item) {
                if (!item.hasOwnProperty('guard')) {
                    return true;
                }

                return this.$userCan(item.guard);
            },
        },
    };
</script>
