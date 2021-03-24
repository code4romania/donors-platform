@props([
    'icon'  => null,
    'value' => null,
    'label' => null,
])

<div class="flex items-center px-4 py-5 space-x-4 bg-white rounded-lg shadow-lg sm:p-6">
    <x-icon-box :icon="$icon" class="flex-shrink-0" />

    <div>
        <dd class="text-2xl font-bold text-gray-900">
            {{ $value }}
        </dd>

        <dt class="text-sm font-semibold text-gray-500 truncate">
            {{ $label }}
        </dt>
    </div>
</div>
