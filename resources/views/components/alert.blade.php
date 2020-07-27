@php
    $type ??= null;

    switch ($type) {
        case 'success':
            $style = 'bg-green-100 text-green-800';
            break;

        default:
            $style = '';
            break;
    }
@endphp

<div role="alert" {{ $attributes->merge(['class' => "p-4 rounded-md flex items-center $style" ]) }}>
    <div class="flex-shrink-0">
        {{ $icon }}
    </div>
    <span class="ml-3 font-medium leading-tight">
        {{ $slot }}
    </span>
</div>
