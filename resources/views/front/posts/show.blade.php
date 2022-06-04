@extends('front.layout')

@section('content')
    <article class="relative px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <x-page-header
            subtitle="Blog"
            :title="$post->title"
        />

        <div class="flex max-w-2xl mx-auto mb-6 space-x-6">
            <div class="inline-flex items-center space-x-2">
                <x-ri-calendar-event-fill class="text-teal-600" class="shrink-0 w-5 h-5 stroke-0" />
                <span>{{ $post->date->isoFormat('LL') }}</span>
            </div>

            @if ($post->author)
                <div class="inline-flex items-center space-x-2">
                    <x-ri-user-fill class="text-teal-600" class="shrink-0 w-5 h-5 stroke-0" />
                    <span>{{ $post->author }}</span>
                </div>
            @endif
        </div>

        <div class="max-w-2xl mx-auto prose prose-lg text-gray-500 prose-teal">
            @isset($post->summary)
                <p class="mb-8">{!! $post->summary !!}</p>
            @endisset

            {!! $post->content !!}
        </div>
    </article>
@endsection
