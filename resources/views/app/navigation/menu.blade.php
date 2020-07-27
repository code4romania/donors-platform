<div
    @click="sidebarOpen = false"
    x-show="sidebarOpen"
    x-transition:enter="transition-opacity duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0"
    :class="{
        'z-40 lg:hidden': sidebarOpen,
    }"
    >
    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
</div>
<div
    x-transition:enter="transition-all duration-300"
    x-transition:enter-start="-ml-64"
    x-transition:enter-end="ml-0"
    x-transition:leave="transition-all duration-300"
    x-transition:leave-start="ml-0"
    x-transition:leave-end="-ml-64"
    class="flex-shrink-0 w-64"
    :class="{
        'flex fixed inset-0 z-40 lg:relative': sidebarOpen,
        '-ml-64 lg:flex lg:ml-0': !sidebarOpen,
    }"
>
    <div class="flex flex-col flex-1">
        <a href="{{ route('dashboard.index') }}" class="flex items-center flex-shrink-0 h-16 px-4 transition-colors duration-150 bg-gray-900 hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">
            <x-icon-logo class="w-full h-8 text-gray-200" />
        </a>

        <div class="flex flex-col flex-1 px-2 py-4 overflow-y-auto bg-gray-800">
            <nav class="grid row-gap-1">
                <x-menu-item
                    icon="heroicon-s-view-grid"
                    :href="route('dashboard.index')"
                    :label="__('menu.dashboard')"
                />

                <x-menu-item
                    icon="heroicon-o-view-grid"
                    href="#"
                    label="__('menu.donors')"
                />

                <x-menu-item
                    icon="heroicon-o-view-grid"
                    label="__('menu.users')"
                    href="#"
                />
            </nav>
        </div>
    </div>
</div>
