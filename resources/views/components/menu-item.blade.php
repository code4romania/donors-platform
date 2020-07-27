@php
    $label ??= null;
    $icon ??= null;
    $href ??= null;

    $base = 'flex items-center px-2 py-2 text-sm font-medium leading-tight transition duration-150 ease-in-out rounded-md group focus:outline-none';

    if (Str::startsWith(request()->url(), $href)) {
        $state = 'text-white bg-gray-900 focus:bg-gray-700';
    } else {
        $state = 'text-gray-300 hover:text-white hover:bg-gray-700 focus:text-white focus:bg-gray-700';
    }
@endphp

<a href="{{ $href }}" class="{{ $base }} {{ $state }}">
    @if ($icon)
        {{ svg($icon, 'w-6 h-6 mr-3 text-gray-300 transition duration-150 ease-in-out group-hover:text-gray-300 group-focus:text-gray-300') }}
    @endif

    {{ $label }}
</a>
