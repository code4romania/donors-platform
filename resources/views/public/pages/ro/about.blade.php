@extends('public.layout')

@section('content')
    <x-section>
        <x-h1 text="Despre proiect" class="text-teal-400" />

        <p class="mt-3 md:mt-5">
            Platforma Donatorilor este o platformă online, creată prin contribuția voluntară a finanțatorilor organizațiilor neguvernamenale din România, care devine astfel publică și are atașate facilități de explorare și vizualizare grafică permițănd membrilor (finanțatorilor instituționali, corporativi, privați etc.) să găsească și să disemineze cu ușurință informații despre proiectele finanțate de către membrii platformei în scopul creșterii relevanței finanțărilor și, în general, al creșterii transparenței modului de operare al organizațiilor neguvernamentale din România și al finanțatorilor lor.
        </p>
    </x-section>

    <x-section>
        <x-h1 text="Inițiatorii proiectului" class="mb-6 text-center" />

        <div class="grid grid-cols-3 lg:grid-cols-5">
            @for ($i = 1; $i <= 15; $i++)
                <img src="{{ asset("assets/images/logos/$i.png") }}" class="shadow-xs" alt="">
            @endfor
        </div>
    </x-section>
@endsection
