@extends('auth.layout')

@section('title', __('auth.login'))

@section('content')
    <x-authentication-card>
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('field.email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error for="email" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('field.password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="current-password" />
                <x-input-error for="password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="mb-1 text-sm font-semibold leading-tight text-blue-500 hover:text-blue-600 focus:outline-none focus:underline" href="{{ route('password.request') }}">
                        {{ __('auth.forgot') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('auth.login') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
@endsection
