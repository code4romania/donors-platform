@extends('auth.layout')

@section('title', __('auth.welcome'))

@section('content')
    <x-authentication-card>
        <form method="POST">
            @csrf

            <input type="hidden" name="email" value="{{ $user->email }}"/>

            <div>
                <x-label value="{{ __('field.password') }}" />
                <x-input class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
                <x-input-error for="password" />
            </div>

            <div class="mt-4">
                <x-label value="{{ __('field.password_confirmation') }}" />
                <x-input class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('auth.welcome') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
@endsection
