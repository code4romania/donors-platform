@php
    $id ??= $name
@endphp

<div class="flex items-center">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out form-checkbox" {{ $attributes }}>
    <label for="{{ $id }}" class="block ml-2 leading-tight text-gray-900">
        {{ $label }}
    </label>

    <x-input-error :field="$name" />
</div>
