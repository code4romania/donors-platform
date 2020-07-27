@extends('layouts.auth')

@section('title', __('auth.register'))

@section('content')
    <form action="{{ route('register') }}" method="post" class="grid row-gap-6">
        @csrf

        <x-input
            type="text"
            name="name"
            :label="__('account.name')"
            :value="old('name')"
            required
            autocomplete="name"
            autofocus
        />

        <x-input
            type="email"
            name="email"
            :label="__('account.email')"
            :value="old('email')"
            required
            autocomplete="email"
        />

        <x-input
            type="password"
            name="password"
            :label="__('account.password')"
            required
            autocomplete="new-password"
        />

        <x-input
            type="password"
            name="password_confirmation"
            :label="__('account.password_confirmation')"
            required
            autocomplete="new-password"
        />

        <x-button type="submit">{{ __('auth.register') }}</x-button>
    </form>
@endsection
