<x-section>
    <div class="px-6 py-10 bg-gradient-to-br lg:bg-gradient-to-tr from-teal-700 to-teal-500 rounded-3xl sm:py-16 sm:px-12 lg:p-20 lg:flex lg:items-center">
        <div class="lg:w-0 lg:flex-1">
            <h2 class="text-3xl font-bold tracking-tight text-white">
                Sign up for our newsletter
            </h2>
            <p class="max-w-3xl mt-4 text-lg text-teal-50">
                Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui Lorem cupidatat commodo. Elit sunt amet
                fugiat.
            </p>
        </div>
        <div class="mt-12 sm:w-full sm:max-w-md lg:mt-0 lg:ml-8 lg:flex-1">
            <form class="sm:flex" action="https://platformadonatorilor.us1.list-manage.com/subscribe/post?u=850758c74ca32d8a7afe21bc2&amp;id=dbdd5ea01b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
                <label for="email" class="sr-only">{{ __('field.email') }}</label>
                <input
                    id="email"
                    name="EMAIL"
                    type="email"
                    autocomplete="email"
                    required
                    class="w-full px-5 py-3 placeholder-gray-500 border-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-teal-700 focus:ring-white"
                    placeholder="{{ __('field.email') }}"
                >
                <button
                    type="submit"
                    class="flex items-center justify-center w-full px-5 py-3 mt-3 text-base font-bold text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-teal-700 focus:ring-white sm:mt-0 sm:ml-3 sm:w-auto sm:flex-shrink-0"
                >
                    {{ __('public.newsletter.subscribe') }}

                </button>
            </form>
            <p class="mt-3 text-sm text-teal-100">
                We care about the protection of your data. Read our
                <!-- space -->
                <a
                    href="#"
                    class="font-medium text-white underline"
                >
                    Privacy Policy.
                </a>
            </p>
        </div>
    </div>
</x-section>
