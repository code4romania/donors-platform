@props([
    'icon' => null
])

@if ($icon)
    <div {{ $attributes->merge(['class' => 'flex items-center justify-center w-12 h-12 text-white rounded-md bg-gradient-to-tr from-teal-600 to-teal-400']) }}>
        {{ svg($icon, 'w-6 h-6 stroke-0') }}
    </div>
@endif
