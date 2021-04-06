@php
    $social = [
        [
            'name' => 'Facebook',
            'icon' => 'ri-facebook-fill',
            'href' => 'https://www.facebook.com/platformadonatorilor',
        ],
        [
            'name' => 'LinkedIn',
            'icon' => 'ri-linkedin-fill',
            'href' => 'https://www.linkedin.com/company/platforma-donatorilor',
        ],
        [
            'name' => 'GitHub',
            'icon' => 'ri-github-fill',
            'href' => 'https://github.com/code4romania/donors-platform',
        ],
    ];

    $menus = [
        [
            'label' => __('public.menu_name.links'),
            'items' => [
                [
                    'name' => __('public.menu.terms'),
                    'href' => localizedRoute('front.page', 'terms'),
                ],
                [
                    'name' => __('public.menu.privacy'),
                    'href' => localizedRoute('front.page', 'privacy'),
                ],
                [
                    'name' => __('public.menu.about'),
                    'href' => localizedRoute('front.page', 'about'),
                ],
                [
                    'name' => 'Code for Romania',
                    'href' => 'https://code4.ro',
                ],
            ],
        ]
];
@endphp

<footer class="bg-gray-100">
    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:py-16 lg:px-12">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8 xl:col-span-1">
                <x-logo />

                <p class="text-base text-gray-500">
                    {{ __('public.tag') }}
                </p>

                <div class="flex mt-8 space-x-6">
                    @foreach ($social as $link)
                        <a href="{{ $link['href'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-gray-500 focus:text-gray-500">
                            <span class="sr-only">{{ $link['name'] }}</span>
                            {{ svg($link['icon'], 'w-6 h-6') }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-12 md:grid-cols-3 xl:mt-0 xl:col-span-2">

                <div></div>
                <div></div>
                @foreach ($menus as $menu)
                    <div>
                        <h3 class="text-sm font-semibold tracking-wider text-gray-400 uppercase">
                            {{ $menu['label'] }}
                        </h3>

                        <ul class="mt-4 space-y-4 text-gray-500">
                            @foreach ($menu['items'] as $item)
                                <li>
                                    <a href="{{ $item['href'] }}" class="hover:text-gray-900 focus:text-gray-900">
                                        {{ $item['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex flex-wrap items-center justify-center pt-8 mt-12 text-center text-gray-400 border-t border-gray-200">
            <p class="w-full sm:w-auto">
                {{ __('public.poweredby') }}
            </p>

            <a href="https://code4.ro" target="_blank" class="mt-3 sm:mt-0 sm:ml-2 sm:w-auto">
                <img src="{{ asset('assets/svg/code4.svg') }}" class="w-24" alt="">
            </a>
        </div>
    </div>
</footer>
