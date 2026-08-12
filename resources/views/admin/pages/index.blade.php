@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Pages') }}</h1>

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10">
        @foreach($pages as $page)
            <div class="flex items-center justify-between px-6 py-4">
                <span>{{ $page->title_en }} <span class="text-brand-900/40">/ {{ $page->title_ka }}</span></span>
                <a href="{{ route('admin.pages.edit', $page) }}" class="text-sm text-brand-600 hover:underline">{{ __('Edit') }}</a>
            </div>
        @endforeach
    </div>
@endsection
