@extends('front.layout')

@section('content')
    <div class="relative px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <x-page-header
            :subtitle="isset($meta['subtitle']) ? $meta['subtitle'] : null"
            :title="$meta['title']"
        />

        <div class="mx-auto prose prose-lg text-gray-500 prose-teal">
            @isset($meta['summary'])
                <p class="mb-8">{!! $meta['summary'] !!}</p>
            @endisset

            {!! $content !!}
        </div>
    </div>
@endsection
