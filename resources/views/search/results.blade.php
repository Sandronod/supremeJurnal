@extends('layouts.public')

@section('title', __('Search results'))

@section('content')
    <div class="bg-white rounded-sm shadow-sm p-6 md:p-10">
        <h1 class="text-2xl md:text-3xl text-brand-900 mb-2">{{ __('Search results') }}</h1>
        @if($query !== '')
            <p class="text-brand-900/60 mb-8">"{{ $query }}"</p>
        @endif

        @if($articles->isEmpty())
            <p class="text-brand-900/60">{{ __('No results found.') }}</p>
        @else
            <ul class="divide-y divide-brand-900/10">
                @foreach($articles as $article)
                    <li class="py-4">
                        <a href="{{ route('articles.show', $article) }}" class="text-brand-900 hover:text-brand-500 font-medium">
                            {{ $article->title }}
                        </a>
                        <p class="text-sm text-brand-900/60">{{ $article->authors }} &middot; {{ $article->issue->label }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
