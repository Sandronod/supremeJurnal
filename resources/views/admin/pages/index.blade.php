@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-xl text-brand-900">{{ __('Pages') }}</h1>
        <a href="{{ route('admin.pages.create') }}" class="bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">{{ __('Create') }}</a>
    </div>

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10">
        @foreach($pages as $page)
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <span>{{ $page->title_en }} <span class="text-brand-900/40">/ {{ $page->title_ka }}</span></span>
                    <span class="ml-2 text-sm text-brand-900/40">/{{ $page->slug }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm shrink-0">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                    @unless($page->isFixed())
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                        </form>
                    @endunless
                </div>
            </div>
        @endforeach
    </div>
@endsection
