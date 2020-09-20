@php
    $menu = [
        [
            'name' => __('public.menu.about'),
            'href' => localizedRoute('public.page', 'about'),
        ],
    ];

@endphp

<div class="relative bg-white shadow-sm">
    <div class="container flex items-center justify-between py-5 md:justify-start">
        <x-logo />

        <nav class="flex items-center justify-end flex-1 space-x-4 text-sm font-medium leading-6 md:space-x-8 md:text-base">
            @foreach ($menu as $item)
                <a href="{{ $item['href'] }}" class="inline-flex text-gray-700 transition duration-150 ease-in-out hover:text-gray-900">
                    {{ $item['name'] }}
                </a>
            @endforeach


            @foreach (config('translatable.locale_names') as $locale => $name)
                @continue(app()->getLocale() === $locale)

                <a
                    href="{{ toLocaleRoute( $locale, Route::currentRouteName(), Route::current()->slug ) }}"
                    class="inline-flex text-gray-700 uppercase transition duration-150 ease-in-out hover:text-gray-900"
                    title="{{ $name }}"
                >
                    {{ strtoupper($locale) }}
                </a>
            @endforeach
        </nav>
    </div>
</div>
