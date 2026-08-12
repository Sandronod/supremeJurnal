@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-xl text-brand-900">{{ __('Articles') }}</h1>
        <a href="{{ route('admin.articles.create') }}" class="bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">{{ __('Create') }}</a>
    </div>

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10">
        @forelse($articles as $article)
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <span class="font-medium">{{ $article->title_en }}</span>
                    <span class="ml-2 text-sm text-brand-900/50">{{ $article->issue->label }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="px-6 py-4 text-brand-900/60">{{ __('No results found.') }}</p>
        @endforelse
    </div>
@endsection
