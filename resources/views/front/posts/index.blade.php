@extends('front.layout')

@section('content')
    <div class="relative px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <x-page-header title="Blog" />

        <div class="grid max-w-2xl gap-16 mx-auto lg:gap-x-5 lg:gap-y-12">
            @foreach ($posts as $post)
                <article class="space-y-2">
                    <time class="block text-sm text-gray-500" datetime="{{ $post->date->toDateString() }}">
                        {{ $post->date->isoFormat('LL') }}
                    </time>

                    <h1 class="text-xl font-semibold text-gray-900">
                        <a href="{{ localizedRoute('front.post', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h1>

                    <p class="text-gray-500">
                        {{ $post->summary }}
                    </p>

                    <a href="{{ localizedRoute('front.post', $post->slug) }}" class="text-base font-semibold text-teal-600 hover:text-teal-500">
                        {{ __('public.read_more') }}
                    </a>
                </article>
            @endforeach
        </div>
    </div>

    <x-newsletter />
@endsection
