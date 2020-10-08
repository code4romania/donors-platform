@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'mt-2 text-sm text-red-600']) }}>{{ $message }}</p>
@enderror
