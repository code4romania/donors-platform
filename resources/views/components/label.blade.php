@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-1 text-sm font-semibold leading-tight text-gray-700 flex-1']) }}>
    {{ $value ?? $slot }}
</label>
