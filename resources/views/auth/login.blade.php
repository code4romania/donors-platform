@extends('layouts.auth')

@section('title', __('auth.login'))

@section('content')
    <form action="{{ route('login') }}" method="post" class="grid row-gap-6">
        @csrf

        <x-input
            type="email"
            name="email"
            :label="__('account.email')"
            required
            autocomplete="email"
            autofocus
        />

        <x-input
            type="password"
            name="password"
            :label="__('account.password')"
            required
            autocomplete="current-password"
        />


        <div class="flex items-center justify-between">
            <x-checkbox
                name="remember"
                :label="__('auth.remember')"
                :checked="boolval(old('remember'))"
            />

            <div class= leading-tight">
                <a
                    href="{{ route('password.request') }}"
                    class="font-medium text-blue-600 transition duration-150 ease-in-out hover:text-blue-500 focus:outline-none focus:underline"
                >
                    {{ __('auth.forgot') }}
                </a>
            </div>
        </div>

        <x-button type="submit">{{ __('auth.login') }}</x-button>
    </form>
@endsection
