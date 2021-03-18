@extends('public.layout')

@section('content')
    <x-section>
        <x-h1 text="Despre proiect" class="text-teal-400" />

        <p class="mt-3 md:mt-5">
            Platforma Donatorilor este o platformă online, creată prin contribuția voluntară a finanțatorilor organizațiilor neguvernamentale din România, care devine astfel publică și are atașate facilități de explorare și vizualizare grafică permițând membrilor (finanțatorilor instituționali, corporativi, privați etc.) să găsească și să disemineze cu ușurință informații despre proiectele finanțate de către membrii platformei în scopul creșterii relevanței finanțărilor și, în general, al creșterii transparenței modului de operare al organizațiilor neguvernamentale din România și al finanțatorilor lor.
        </p>
    </x-section>

    <x-section>
        <x-h1 text="Inițiatorii proiectului" class="text-center" />
        <h2 class="mb-6 text-lg text-center md:text-xl">(în ordine alfabetică)</h2>

        <div class="grid grid-cols-3 lg:grid-cols-5">
            @for ($i = 1; $i <= 15; $i++)
                <img src="{{ asset("assets/images/logos/$i.png") }}" class="ring-1 ring-black ring-opacity-5" alt="">
            @endfor
        </div>
    </x-section>
@endsection
