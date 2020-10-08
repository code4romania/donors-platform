@extends('auth.layout')

@section('title', __('auth.forgot'))

@section('content')
    <x-authentication-card>
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label value="{{ __('field.email') }}" />
                <x-input class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error for="email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('auth.send_link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
@endsection
