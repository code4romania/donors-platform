@extends('front.layout')

@section('content')
    <div class="relative px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <x-page-header
            :subtitle="__('public.pages.about.subtitle')"
            :title="__('public.pages.about.title')"
        />

        <div class="mx-auto prose prose-lg text-gray-500 prose-teal">
            @foreach (Arr::wrap(__('public.pages.about.summary')) as $line)
                {!! Str::markdown($line) !!}
            @endforeach
        </div>

        <x-section>
            <x-h1 :text="__('public.pages.about.founders')" class="text-center" />
            <h2 class="mb-6 text-lg text-center md:text-xl">
                {{ __('public.pages.about.alphabetical') }}
            </h2>

            <div class="grid grid-cols-3 lg:grid-cols-5">
                @for ($i = 1; $i <= 15; $i++)
                    <img src="{{ asset("assets/images/logos/$i.png") }}" class="ring-1 ring-black ring-opacity-5" alt="">
                @endfor
            </div>
        </x-section>
    </div>
@endsection
