<x-section {{ $attributes->merge(['class' => 'bg-gray-50'])}}>
    <div class="lg:flex lg:items-center">
        <div class="lg:w-0 lg:flex-1">
            <h2 class="text-3xl font-bold tracking-tight">
                {{ __('public.newsletter.title') }}
            </h2>
            <p class="max-w-3xl mt-4 text-lg text-gray-500">
                {{ __('public.newsletter.text') }}
            </p>
        </div>

        <form class="w-full mt-12 md:max-w-md lg:mt-0 lg:ml-8 lg:flex-1 sm:flex" action="https://platformadonatorilor.us1.list-manage.com/subscribe/post?u=850758c74ca32d8a7afe21bc2&amp;id=dbdd5ea01b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
            <label for="email" class="sr-only">{{ __('field.email') }}</label>
            <input
                id="email"
                name="EMAIL"
                type="email"
                autocomplete="email"
                required
                class="w-full px-5 py-3 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:max-w-xs"
                placeholder="{{ __('field.email') }}"
            >


            <button
                type="submit"
                class="relative flex items-center justify-center w-full px-6 py-2 mt-3 text-base font-bold tracking-wide text-white bg-teal-500 border border-transparent rounded-md shadow hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 focus:ring-offset-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:flex-shrink-0"
            >
                {{ __('public.newsletter.subscribe') }}
            </button>
        </form>
    </div>
</x-section>
