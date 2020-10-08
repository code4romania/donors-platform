@extends('auth.layout')

@section('title', __('auth.reset'))

@section('content')
    <x-authentication-card>
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="block">
                <x-label value="{{ __('field.email') }}" />
                <x-input class="block w-full mt-1" type="email" name="email" :value="old('email', $email)" required autofocus />
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
                <x-button>
                    {{ __('auth.reset') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
@endsection
