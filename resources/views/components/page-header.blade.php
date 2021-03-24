@props([
    'title'       => null,
    'subtitle'    => null,
    'description' => null,
])

<div class="relative mx-auto mb-8 text-lg max-w-prose">
    <h1 class="text-center">
        @if ($subtitle)
            <span class="block text-base font-semibold tracking-wider text-teal-600 uppercase">
                {{ $subtitle }}
            </span>
        @endif
        <span class="block mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
            {{ $title }}
        </span>
    </h1>

    @if ($description)
        <p class="mt-8 text-xl leading-8 text-gray-500">
            {{ $description }}
        </p>
    @endif
</div>
