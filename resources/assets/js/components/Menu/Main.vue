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
                class="px-4 text-gray-900 focus:outline-none focus:bg-gray-200 hover:bg-gray-200 lg:hidden"
                aria-label="Open sidebar"
            >
                <svg-vue icon="System/menu-fill" class="w-6 h-6 fill-current" />
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
                :href="$route('dashboard')"
                class="flex items-center flex-shrink-0 h-16 px-4 transition-colors duration-150 bg-white"
            >
                <Logo class="w-full h-10" />
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
                        icon="Editor/question-mark"
                        :href="$route('help')"
                        :label="$t('dashboard.menu.help')"
                    />

                    <menu-item
                        icon="System/logout-box-line"
                        :href="$route('public.page')"
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
            let own = {
                id: this.$page.auth.organization.id,
                type: this.$page.auth.role,
            };

            let ownArgs = {
                filters: {
                    [own.type]: own.id,
                },
            };

            return {
                open: false,
                items: [
                    {
                        icon: 'System/dashboard-fill',
                        href: this.$route('dashboard'),
                        label: this.$t('dashboard.menu.dashboard'),
                    },
                    {
                        icon: 'Finance/money-euro-circle-line',
                        href: this.$route('donors.index'),
                        label: this.$t('model.donor.plural'),
                        guard: this.$userCan('view', 'donors'),
                        children: [
                            {
                                href: this.$route('donors.index', ownArgs),
                                label: this.$t('model.donor.own'),
                                guard: this.$userHasRole('manager'),
                            },
                            {
                                href: this.routeIfId('donors.show', own.id),
                                label: this.$t('dashboard.own_profile'),
                                guard: this.$userHasRole('donor'),
                            },
                        ],
                    },
                    {
                        icon: 'Finance/money-euro-circle-line',
                        href: this.$route('managers.index'),
                        label: this.$t('model.manager.plural'),
                        guard: this.$userCan('view', 'managers'),
                        children: [
                            {
                                href: this.$route('managers.index', ownArgs),
                                label: this.$t('model.manager.own'),
                                guard: this.$userHasRole('donor'),
                            },
                            {
                                href: this.routeIfId('managers.show', own.id),
                                label: this.$t('dashboard.own_profile'),
                                guard: this.$userHasRole('manager'),
                            },
                        ],
                    },
                    {
                        icon: 'Design/focus-3-line',
                        href: this.$route('domains.index'),
                        label: this.$t('model.domain.plural'),
                        guard: this.$userCan('view', 'domains'),
                        // children: [
                        //     {
                        //         href: this.$route('domains.index', ownArgs),
                        //         label: this.$t('model.domain.own'),
                        //         guard: !this.$userHasRole('admin'),
                        //     },
                        // ],
                    },
                    {
                        icon: 'Finance/funds-line',
                        href: this.$route('grants.index'),
                        label: this.$t('model.grant.plural'),
                        guard: this.$userCan('view', 'grants'),
                        children: [
                            {
                                href: this.$route('grants.index', ownArgs),
                                label: this.$t('model.grant.own'),
                                guard: !this.$userHasRole('admin'),
                            },
                        ],
                    },
                    {
                        icon: 'Editor/organization-chart',
                        href: this.$route('grantees.index'),
                        label: this.$t('model.grantee.plural'),
                        guard: this.$userCan('view', 'grantees'),
                        children: [
                            {
                                href: this.$route('grantees.index', ownArgs),
                                label: this.$t('model.grantee.own'),
                                guard: !this.$userHasRole('admin'),
                            },
                        ],
                    },
                    {
                        icon: 'User/user-settings-line',
                        href: this.$route('users.index'),
                        label: this.$t('dashboard.menu.users'),
                        guard: this.$userCan('view', 'users'),
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

                return item.guard;
            },
            routeIfId(name, id) {
                if (!id) {
                    return '';
                }

                return this.$route(name, id);
            },
        },
    };
</script>
