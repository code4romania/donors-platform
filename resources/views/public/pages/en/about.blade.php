@extends('public.layout')

@section('content')
    <x-section>
        <x-h1 text="About the project" class="text-teal-400" />

        <p class="mt-3 md:mt-5">
            Donors Platform is an online application, developed through the voluntary contribution of donors in Romania, which therefore becomes public and benefits from exploration and visualization tools allowing its members (institutional, corporate, private donors etc) to find and easily disseminate information about the projects funded by the members of this platform, in order to increase the relevance of funding and, in general, to increase transparency in how non-profit organisations and their funders operate.
        </p>
    </x-section>

    <x-section>
        <x-h1 text="Project founders" class="text-center" />
        <h2 class="mb-6 text-lg text-center md:text-xl">(in alphabetical order)</h2>

        <div class="grid grid-cols-3 lg:grid-cols-5">
            @for ($i = 1; $i <= 15; $i++)
                <img src="{{ asset("assets/images/logos/$i.png") }}" class="shadow-xs" alt="">
            @endfor
        </div>
    </x-section>
@endsection
