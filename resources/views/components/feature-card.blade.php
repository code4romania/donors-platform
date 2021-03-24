@props([
    'icon'  => null,
    'title' => null,
    'text'  => null,
])

<div class="space-y-3 text-left">
    <dt class="flex items-center space-x-3">
        <x-icon-box :icon="$icon" />

        @if ($title)
            <h3 class="text-xl font-semibold leading-6 text-gray-900">{{ $title }}</h3>
        @endif
    </dt>

    <dd class="text-gray-600">{{ $text }}</dd>
</div>
