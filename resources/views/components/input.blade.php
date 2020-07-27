@php
    $id ??= $name;
    $label ??= false;
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="block font-medium leading-tight text-gray-700">
            {{ $label }}
        </label>
    @endif

    <div class="mt-1 rounded-md shadow-sm">
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="block w-full transition duration-150 ease-in-out rounded-md form-input" {{ $attributes }}>
    </div>

    <x-input-error :field="$name" />
</div>
