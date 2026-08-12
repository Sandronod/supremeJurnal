@extends('layouts.public')

@section('title', $article->title)

@section('content')
    <article class="bg-white rounded-sm shadow-sm p-6 md:p-10">
        @if($article->cover_image_path)
            <img src="{{ asset('storage/'.$article->cover_image_path) }}" alt="{{ $article->title }}"
                 class="w-full max-h-96 object-cover rounded-sm mb-6">
        @endif

        <p class="text-sm text-brand-600 mb-2">
            <a href="{{ route('issues.show', $article->issue) }}" class="hover:underline">{{ $article->issue->label }}</a>
        </p>
        <h1 class="text-2xl md:text-3xl text-brand-900 mb-2">{{ $article->title }}</h1>
        <p class="text-brand-900/70 mb-8">{{ $article->authors }}</p>

        @if($article->abstract)
            <div class="mb-8">
                <h2 class="text-sm uppercase font-heading text-brand-900/60 mb-2">{{ __('Abstract') }}</h2>
                <p class="text-brand-900/90 leading-relaxed">{{ $article->abstract }}</p>
            </div>
        @endif

        @if($article->pdf_path)
            <a href="{{ asset('storage/'.$article->pdf_path) }}" target="_blank" rel="noopener"
               class="inline-block bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">
                {{ __('Download PDF') }}
            </a>
        @endif
    </article>
@endsection
