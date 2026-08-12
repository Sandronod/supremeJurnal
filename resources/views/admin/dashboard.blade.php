@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Dashboard') }}</h1>

    <div class="grid grid-cols-2 gap-4 max-w-md">
        <div class="bg-white rounded-sm shadow-sm p-6">
            <p class="text-3xl font-heading text-brand-900">{{ $issuesCount }}</p>
            <p class="text-sm text-brand-900/60">{{ __('Issues') }}</p>
        </div>
        <div class="bg-white rounded-sm shadow-sm p-6">
            <p class="text-3xl font-heading text-brand-900">{{ $articlesCount }}</p>
            <p class="text-sm text-brand-900/60">{{ __('Articles') }}</p>
        </div>
    </div>
@endsection
