@extends('layouts.public')

@section('title', $issue->label)

@section('content')
    <div class="bg-white rounded-sm shadow-sm p-6 md:p-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                @if($isCurrent)
                    <span class="inline-block text-xs uppercase font-heading bg-brand-500 text-white px-2 py-1 mb-2">{{ __('Current') }}</span>
                @endif
                <h1 class="text-2xl md:text-3xl text-brand-900">{{ $issue->label }}</h1>
            </div>

            @if($issue->pdf_path)
                <a href="{{ asset('storage/'.$issue->pdf_path) }}" target="_blank" rel="noopener"
                   class="inline-block bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm shrink-0">
                    {{ __('Download full issue (PDF)') }}
                </a>
            @endif
        </div>

        <h2 class="text-lg text-brand-900 mb-4">{{ __('Articles in this issue') }}</h2>

        @if($issue->articles->isEmpty())
            <p class="text-brand-900/60">{{ __('No results found.') }}</p>
        @else
            <ul class="divide-y divide-brand-900/10">
                @foreach($issue->articles as $article)
                    <li class="py-4 flex items-center gap-4">
                        @if($article->cover_image_path)
                            <img src="{{ asset('storage/'.$article->cover_image_path) }}" alt=""
                                 class="w-16 h-16 object-cover rounded-sm shrink-0">
                        @endif
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="text-brand-900 hover:text-brand-500 font-medium">
                                {{ $article->title }}
                            </a>
                            <p class="text-sm text-brand-900/60">{{ $article->authors }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('issues.archive') }}" class="inline-block mt-8 text-sm text-brand-600 hover:underline">
            &larr; {{ __('Back to archive') }}
        </a>
    </div>
@endsection
