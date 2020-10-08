@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full transition duration-150 ease-in-out rounded-md shadow-sm form-input']) !!}>
