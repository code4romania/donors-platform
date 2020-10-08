@php
    $mailto = 'mailto:contact@code4.ro?subject=';
@endphp

@extends('public.layout')

@section('content')
    <x-section>
        <div class="grid items-center gap-20 lg:grid-cols-2">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <img src="{{ asset('assets/images/hero.png') }}" class="w-full" alt="">
            </div>

            <div class="w-full mx-auto text-center lg:text-left">
                <x-h1 text="Welcome!" class="text-teal-400" />

                <p class="max-w-md mx-auto mt-3 md:mt-5 md:max-w-3xl">
                    Donors Platform is a digital instrument that allows information visualisation about funding in the non-profit sector in Romania. The data presented on this platform is being publicly offered by the donors registered in the platform. If you represent a foundation, a federation or a company and you want to join this initiative, we invite you to <a href="{{ $mailto }}" class="underline hover:no-underline">send us a message</a>.
                </p>
            </div>
        </div>
    </x-section>

    <x-section>
        <x-h1 text="Donors platform" class="mb-6 text-center" />

        <div class="grid gap-16 text-center md:grid-cols-3">
            <div>
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Aggregated data</h2>
                <p> The data you can see below is aggregated from the detailed reports of the donors. You may see, aided by the available filters how much funding is allocated on each main domain in Romania.</p>
            </div>
            <div>
                <img src="{{ asset('assets/images/dashboard.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Intuitive dashboard</h2>
                <p>Every donor joining the platform will be able to open its data with the help of a simple and intuitive dashboard and will benefit from permanent support from the administrator of the platform.</p>
            </div>
            <div>
                <img src="{{ asset('assets/images/vizualizare.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Interactive view</h2>
                <p>The data can be analyzed directly in the platform or can be downloaded and processed for further analysis. All the information on the platform belongs to donors, for further details please contact each donor individually.</p>
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="grid items-center gap-20 lg:grid-cols-2">
            <div class="w-full mx-auto text-center lg:text-left">
                <x-h1 text="Join us" class="text-teal-400" />

                <p class="max-w-md mx-auto my-3 md:my-5 md:max-w-3xl">
                    If you want to join the donor community that opens its data and you want to benefit from an account in the platform then please contact us via e-mail to start a conversation. Press the buton below and send us a message.
                </p>

                <x-button-link :link="$mailto">Request account</x-button-link>
            </div>

            <div class="max-w-lg mx-auto lg:max-w-none">
                <img src="{{ asset('assets/images/hero2.png') }}" class="w-full" alt="">
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="mx-auto mb-12 text-center">
            <x-h1 text="Results" class="mb-6 text-center text-teal-300" />

            <p>Discover below all the data publicly available at this moment in time in the platform. Until today, on this website you can find:</p>
        </div>

        <div class="grid gap-16 md:grid-cols-3">
            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">15 donors</h2>
                    <p>registered in the platform</p>
                </div>
            </div>

            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">14.256.986 euro</h2>
                    <p>invested in 20 domains</p>
                </div>
            </div>

            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">482 projects</h2>
                    <p>funded in total</p>
                </div>
            </div>
        </div>
    </x-section>
@endsection
