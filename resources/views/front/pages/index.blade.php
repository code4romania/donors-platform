@php
    $mailto = 'mailto:platformadonatorilor@code4.ro';
@endphp

@extends('front.layout')

@section('content')
    <x-section>
        <div class="grid items-center gap-8 lg:grid-cols-2">
            <div class="hidden md:block">
                <img
                    class="w-full max-w-md mx-auto sm:max-w-none"
                    src="{{ asset('assets/svg/hero.svg') }}"
                    alt=""
                >
            </div>

            <div class="lg:py-24">
                <img src="{{ asset('assets/svg/logo.svg') }}" class="w-96" alt="">
                <h1 class="sr-only">{{ __('public.title') }}</h1>

                <div class="my-6 prose text-gray-500 prose-teal sm:prose-xl lg:prose-lg xl:prose-xl">
                    @foreach (__('public.description') as $line)
                        <p>{{ $line }}</p>
                    @endforeach
                </div>

                <x-button-link :link="$mailto" icon="ri-mail-send-line">
                    {{ __('public.request_account') }}
                </x-button-link>
            </div>
        </div>
    </x-section>

    <x-section class="bg-gray-50">
        <h1 class="text-center">
            <span class="block text-base font-semibold tracking-wider text-teal-600 uppercase">
                {{ __('public.what.subtitle') }}
            </span>
            <span class="block mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                {{ __('public.what.title') }}
            </span>
        </h1>

        <div class="mx-auto mt-5 prose text-gray-500 prose-teal">
            {!! Str::markdown(__('public.what.text')) !!}
        </div>

        <div class="grid gap-12 mt-12 lg:grid-cols-3">
            <x-feature-card
                icon="ri-filter-line"
                :title="__('public.what.aggregate_title')"
                :text="__('public.what.aggregate_text')"
            />

            <x-feature-card
                icon="ri-computer-line"
                :title="__('public.what.dashboard_title')"
                :text="__('public.what.dashboard_text')"
            />

            <x-feature-card
                icon="ri-pie-chart-line"
                :title="__('public.what.interactive_title')"
                :text="__('public.what.interactive_text')"
            />
        </div>
    </x-section>


    <x-section id="chart" class="bg-gray-100">
        <h1 class="text-center">
            <span class="block mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                {{ __('public.chart.title') }}
            </span>
        </h1>

        <div class="mx-auto mt-5 prose text-gray-500 prose-teal">
            {{ __('public.chart.text') }}
        </div>

        <chart-front
            class="mt-12"
            data-url="{{ localizedRoute('front.chart-data') }}"
            :labels="{{ collect([
                'years'   => __('dashboard.filter.year'),
                'domains' => __('dashboard.filter.domain'),
                'reset'   => __('dashboard.action.reset'),
            ]) }}"
            :currencies="{{ collect(config('money.currencies.iso')) }}"
            :domains="{{ $domains }}"
            :years="{{ $years }}"
        >
            <template #notice>
                <div class="flex p-4 mx-auto mb-4 space-x-3 border-l-4 border-yellow-400">
                    <x-ri-alert-fill class="flex-shrink-0 w-5 h-5 text-yellow-400" />

                    <p class="text-sm text-yellow-700">
                        {{ __('public.chart.disclaimer') }}
                    </p>
                </div>
            </template>
        </chart-front>
    </x-section>

    <x-section class="bg-gray-50">
        <h1 class="block mt-2 text-3xl font-bold leading-8 tracking-tight text-center text-gray-900 sm:text-4xl">
                {{ __('public.results.title') }}
        </h1>


        <div class="mx-auto mt-5 prose text-gray-500 prose-teal">
            {{ __('public.results.text') }}
        </div>

        <dl class="grid grid-cols-1 gap-5 mt-12 lg:grid-cols-3">
            <x-stats-card
                :value="__('public.results.first_box')"
            />

            <x-stats-card
                icon="ri-pie-chart-line"
                :value="$donors_count"
                :label="__('public.results.donors_count')"
            />

            <x-stats-card
                icon="ri-pie-chart-line"
                :value="$grants_total"
                :label="__('public.results.grants_total', [
                    'domains_count' => $domains_count
                ])"
            />

            <x-stats-card
                icon="ri-pie-chart-line"
                :value="$projects_count"
                :label="__('public.results.projects_count')"
            />

            <x-stats-card
                icon="ri-pie-chart-line"
                :value="$foundations_count"
                :label="__('public.results.foundations_count')"
            />

            <x-stats-card
                icon="ri-pie-chart-line"
                :value="$grantees_count"
                :label="__('public.results.grantees_count')"
            />
        </dl>
    </x-section>

    <x-section>
        <div class="grid items-center gap-8 lg:grid-cols-5">
            <div class="max-w-xl px-4 mx-auto sm:px-6 lg:py-16 lg:mx-0 lg:px-0 lg:col-span-2">
                <div>
                    <x-icon-box icon="ri-flashlight-line" />
                    <div class="my-6">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                            {{ __('public.join.title') }}
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            {{ __('public.join.text') }}
                        </p>
                    </div>

                    <x-button-link :link="$mailto" icon="ri-mail-send-line">
                        {{ __('public.request_account') }}
                    </x-button-link>
                </div>
            </div>

            <div class="lg:col-span-3">
                <img
                    class="shadow-xl rounded-xl ring-1 ring-black ring-opacity-5"
                    src="{{ asset('assets/images/screenshot-1.png') }}"
                    alt="Screenshot"
                />
            </div>
        </div>
    </x-section>
@endsection
