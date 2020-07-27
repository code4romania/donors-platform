@extends('layouts.auth')

@section('title', __('auth.reset'))

@section('content')
    <form action="{{ route('password.update') }}" method="post" class="grid row-gap-6">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-input
            type="email"
            name="email"
            :label="__('account.email')"
            :value="$email ?? old('email')"
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
