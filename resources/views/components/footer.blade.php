@php
    $menu = [
        [
            'name' => __('public.menu.terms'),
            'href' => localizedRoute('public.page', 'terms'),
        ],
        [
            'name' => __('public.menu.privacy'),
            'href' => localizedRoute('public.page', 'privacy'),
        ],
        [
            'name' => __('public.menu.about'),
            'href' => localizedRoute('public.page', 'about'),
        ],
    ];
@endphp

<div class="container flex items-center justify-end py-8">
    <p>{{ __('public.poweredby') }}</p>
    <a href="https://code4.ro" target="_blank" class="inline-block ml-2">
        <img src="{{ asset('assets/svg/code4.svg') }}" class="w-24" alt="">
    </a>
</div>

<footer class="relative bg-gray-800 shadow-xs">
    <div class="container py-12 lg:py-16">
        <div class="grid gap-y-20 gap-x-12 lg:grid-cols-4">
            <div class="lg:col-span-3">
                <x-logo />

                <p class="mt-8 text-gray-300">Doloribus nesciunt vero. Sit ea vel ut a architecto quia.</p>

                <div class="flex mt-8 space-x-4">
                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-500 transition-colors duration-150 rounded hover:text-gray-300 focus:outline-none focus:shadow-outline-gray focus:text-gray-300">
                        <span class="sr-only">Facebook</span>
                        <x-ri-facebook-fill class="w-6 h-6" />
                    </a>

                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-500 transition-colors duration-150 rounded hover:text-gray-300 focus:outline-none focus:shadow-outline-gray focus:text-gray-300">
                        <span class="sr-only">Twitter</span>
                        <x-ri-twitter-fill class="w-6 h-6" />
                    </a>
                    <a href="#" target="_blank" rel="noopener noreferrer" class="text-gray-500 transition-colors duration-150 rounded hover:text-gray-300 focus:outline-none focus:shadow-outline-gray focus:text-gray-300">
                        <span class="sr-only">LinkedIn</span>
                        <x-ri-linkedin-fill class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <nav class="leading-tight">
                <h2 class="font-semibold text-yellow-300">Linkuri utile</h2>
                <ul class="mt-4 space-y-4 text-gray-400">
                    @foreach ($menu as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="hover:text-gray-100 focus:outline-none focus:underline focus:text-gray-100">
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</footer>
