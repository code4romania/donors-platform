@props([
    'clickable' => false,
    'symbol'    => false,
])


@if ($clickable)
    <a href="{{ route('front.index') }}" aria-current="page" class="inline-flex">
@else
    <div class="inline-flex">
@endif

@if ($symbol)
    <img src="{{ asset('assets/svg/symbol.svg') }}" class="h-12" alt="">
@else
    <img src="{{ asset('assets/svg/symbol.svg') }}" class="h-10 sm:hidden" alt="">
    <img src="{{ asset('assets/svg/logo.svg') }}" class="hidden h-10 sm:block" alt="">
@endif

@if ($clickable)
    </a>
@else
    </div>
@endif

