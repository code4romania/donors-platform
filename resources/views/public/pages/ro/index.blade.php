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
                <x-h1 text="Bine ai venit!" class="text-teal-400" />

                <p class="max-w-md mx-auto mt-3 md:mt-5 md:max-w-3xl">
                    Platforma donatorilor este un instrument digital care permite vizualizarea informațiilor despre alocarea finanțărilor din sectorul neguvernamental din România. Datele prezente pe această platformă sunt oferite în mod public de către finanțatorii înscriși în platformă. Dacă reprezinți o fundație, o federație sau o companie și vrei să te alături acestui demers, te invităm să ne <a href="{{ $mailto }}" class="underline hover:no-underline">transmiți un mesaj</a>.
                </p>
            </div>
        </div>
    </x-section>

    <x-section>
        <x-h1 text="Platforma donatorilor" class="mb-6 text-center" />

        <div class="grid gap-16 text-center md:grid-cols-3">
            <div>
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Date agregate</h2>
                <p>Datele pe care le poți vedea mai jos sunt agregate din raportările detaliate ale finanțatorilor. Poți vedea cu ajutorul filtrelor disponibile câți bani sunt alocați pe principalele domenii de intervenție din România.</p>
            </div>
            <div>
                <img src="{{ asset('assets/images/dashboard.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Dashboard intuitiv</h2>
                <p>Orice donator care se alătură platformei va putea să își deschidă datele cu ajutorului unui panoul de administrare simplu și intuitiv și va avea parte de sprijin permanent din partea administratorului.</p>
            </div>
            <div>
                <img src="{{ asset('assets/images/vizualizare.png') }}" class="w-20 mx-auto mb-5" alt="">

                <h2 class="mb-3 text-lg font-semibold">Vizualizare interactivă</h2>
                <p>Datele pot fi analizate direct din platformă, sau pot fi descărcate și procesate pentru analize în profunzime. Toate informațiile prezente în platformă aparțin donatorilor, pentru informații mai detaliate contactați fiecare donator individual.</p>
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="grid items-center gap-20 lg:grid-cols-2">
            <div class="w-full mx-auto text-center lg:text-left">
                <x-h1 text="Vino alături de noi" class="text-teal-400" />

                <p class="max-w-md mx-auto my-3 md:my-5 md:max-w-3xl">
                    Dacă vrei să te alături comunității de donatori care își deschid datele și vrei să beneficiezi de un cont în platformă atunci te rugăm să ne contactezi via e-mail pentru a porni o discuție. Apasă pe butonul de mai jos și trimite-ne un mesaj.
                </p>

                <x-button-link :link="$mailto">Solicită cont</x-button-link>
            </div>

            <div class="max-w-lg mx-auto lg:max-w-none">
                <img src="{{ asset('assets/images/hero2.png') }}" class="w-full" alt="">
            </div>
        </div>
    </x-section>

    <x-section>
        <div class="mx-auto mb-12 text-center">
            <x-h1 text="Rezultate" class="mb-6 text-center text-teal-300" />

            <p>Descoperă mai jos toate datele disponibile public la acest moment în platformă. Până azi, în cadrul platformei donatorilor există:</p>
        </div>

        <div class="grid gap-16 md:grid-cols-3">
            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">15 donatori</h2>
                    <p>Înregistrați în platformă</p>
                </div>
            </div>

            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">14.256.986 euro</h2>
                    <p>investiți în 20 de domenii</p>
                </div>
            </div>

            <div class="flex items-center">
                <img src="{{ asset('assets/images/agregate.png') }}" class="w-20 mr-2" alt="">

                <div>
                    <h2 class="text-lg font-semibold">482 proiecte</h2>
                    <p>finanțate în ultimul an</p>
                </div>
            </div>
        </div>
    </x-section>
@endsection
