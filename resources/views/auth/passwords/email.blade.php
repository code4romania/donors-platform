@extends('layouts.auth')

@section('title', __('auth.reset'))

@section('message')
    @if (session('status'))
        <x-alert type="success" class="mb-4">
            <x-slot name="icon">
                <x-heroicon-s-check-circle class="w-5" />
            </x-slot>

            {{ session('status') }}
        </x-alert>
    @endif
@endsection

@section('content')
    <form action="{{ route('password.email') }}" method="post" class="grid row-gap-6">
        @csrf

        <x-input
            type="email"
            name="email"
            :label="__('account.email')"
            :value="old('email')"
            required
            autocomplete="email"
            autofocus
        />

        <x-button type="submit">{{ __('auth.send_link') }}</x-button>
    </form>
@endsection
