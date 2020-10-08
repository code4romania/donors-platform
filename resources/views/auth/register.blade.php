@extends('auth.layout')

@section('title', __('auth.register'))

@section('content')
    <x-authentication-card>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label value="{{ __('field.name') }}" />
                <x-input class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error for="name" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('field.email') }}" />
                <x-input class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
                <x-input-error for="email" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('field.password') }}" />
                <x-input class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                <x-input-error for="password" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('field.password_confirmation') }}" />
                <x-input class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error for="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('auth.already_registered') }}
                </a>

                <x-button class="ml-4">
                    {{ __('auth.register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
@endsection
