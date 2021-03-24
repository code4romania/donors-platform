@props(['link', 'icon' => null])

<a href="{{ $link }}" class="relative inline-flex items-center px-6 py-2 text-base font-bold tracking-wide text-white bg-teal-600 rounded-md shadow hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
    @if ($icon)
        {{ svg($icon, 'w-5 h-5 mr-3 -ml-1 stroke-0') }}
    @endif
    {{ $slot }}
</a>
