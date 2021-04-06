@php
    $menu = [
        [
            'name' => __('public.menu.about'),
            'href' => localizedRoute('front.page', 'about'),
        ],
        [
            'name' => __('public.menu.blog'),
            'href' => localizedRoute('front.page', 'blog'),
        ],
        [
            'name' => __('public.menu.contact'),
            'href' => 'mailto:',
        ],
    ];
@endphp

<header class="relative" v-click-away="hideMenu">
    <div class="flex items-center justify-between px-6 py-6 mx-auto border-b border-gray-200 max-w-7xl xl:px-8">
        <x-logo clickable class="flex-1 mr-8" />

        <div class="-mr-2 md:hidden">
            <button
                type="button"
                class="inline-flex items-center justify-center p-2 bg-white rounded-md text-warm-gray-400 hover:bg-warm-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500"
                @@click="toggleMenu"
            >
                <span class="sr-only">Toggle menu</span>
                <template v-if="menuOpen === false">
                    {{ svg('ri-menu-fill', 'w-6 h-6 stroke-0') }}
                </template>
                <template v-else>
                    {{ svg('ri-close-fill', 'w-6 h-6 stroke-0') }}
                </template>
            </button>
        </div>

        <nav class="items-center hidden space-x-8 md:flex">
            @foreach ($menu as $item)
                <a href="{{ $item['href'] }}" class="font-semibold text-gray-500 hover:text-gray-900">
                    {{ $item['name'] }}
                </a>
            @endforeach

            @foreach (config('translatable.locale_names') as $locale => $name)
                @continue(app()->getLocale() === $locale)

                <a
                    href="{{ toLocaleRoute( $locale, Route::currentRouteName(), Route::current()->slug ) }}"
                    class="px-3 py-2 text-base font-semibold leading-none text-gray-900 bg-gray-100 border border-transparent rounded hover:text-gray-900 hover:bg-gray-200"
                    title="{{ $name }}"
                >
                    {{ strtoupper($locale) }}
                </a>
            @endforeach
        </nav>
    </div>

    <div
        v-if="menuOpen"
        class="absolute inset-x-0 z-30 transition origin-top transform top-full lg:hidden"
        v-cloak
    >
        <div class="pt-5 pb-6 overflow-hidden bg-white shadow-lg ring-1 ring-black ring-opacity-5">
            <div class="px-2 space-y-1">
                @foreach ($menu as $item)
                    <a href="{{ $item['href'] }}" class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-50">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>
            <div class="flex justify-end px-5 mt-6 space-x-2">
                @foreach (config('translatable.locale_names') as $locale => $name)
                    @continue(app()->getLocale() === $locale)

                    <a
                        href="{{ toLocaleRoute( $locale, Route::currentRouteName(), Route::current()->slug ) }}"
                        class="px-3 py-2 text-base font-semibold leading-none text-gray-900 bg-gray-100 border border-transparent rounded hover:text-gray-900 hover:bg-gray-200"
                        title="{{ $name }}"
                    >
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</header>
