@php
    $menu = [
        [
            'name' => __('public.menu.blog'),
            'href' => localizedRoute('front.page', 'blog'),
        ],
        [
            'name' => __('public.menu.about'),
            'href' => localizedRoute('front.page', 'about'),
        ],
    ];
@endphp

<header class="relative">
    <div class="relative flex items-center justify-between px-6 pt-6 mx-auto max-w-7xl xl:px-8">
        <x-logo clickable class="flex-1 mr-8" />

        <nav class="flex items-center space-x-8">
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
        x-show="open"
        x-transition:enter="duration-150 ease-out"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="duration-100 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-description="Mobile menu, show/hide based on menu open state."
        class="absolute inset-x-0 top-0 z-30 p-2 transition origin-top transform lg:hidden"
        x-ref="panel"
        @click.away="open = false"
        style="display: none"
    >
        <div
            class="overflow-hidden bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5"
        >
            <div class="flex items-center justify-between px-5 pt-4">
                <div>
                    <img
                        class="w-auto h-8"
                        src="https://tailwindui.com/img/logos/workflow-mark.svg?color=teal&amp;shade=500"
                        alt=""
                    />
                </div>
                <div class="-mr-2">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center p-2 bg-white rounded-md text-warm-gray-400 hover:bg-warm-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500"
                        @click="toggle"
                    >
                        <span class="sr-only">Close menu</span>
                        <svg
                            class="w-6 h-6"
                            x-description="Heroicon name: outline/x"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="pt-5 pb-6">
                <div class="px-2 space-y-1">
                    <a
                        href="#"
                        class="block px-3 py-2 text-base font-medium rounded-md text-warm-gray-900 hover:bg-warm-gray-50"
                        >Changelog</a
                    >

                    <a
                        href="#"
                        class="block px-3 py-2 text-base font-medium rounded-md text-warm-gray-900 hover:bg-warm-gray-50"
                        >About</a
                    >

                    <a
                        href="#"
                        class="block px-3 py-2 text-base font-medium rounded-md text-warm-gray-900 hover:bg-warm-gray-50"
                        >Partners</a
                    >

                    <a
                        href="#"
                        class="block px-3 py-2 text-base font-medium rounded-md text-warm-gray-900 hover:bg-warm-gray-50"
                        >News</a
                    >
                </div>
                <div class="px-5 mt-6">
                    <a
                        href="#"
                        class="block w-full px-4 py-2 font-medium text-center text-white bg-teal-500 border border-transparent rounded-md shadow hover:bg-teal-600"
                        >Login</a
                    >
                </div>
            </div>
        </div>
    </div>
</header>
