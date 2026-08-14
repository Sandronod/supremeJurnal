@extends('layouts.public')

@section('title', $issue->label)

@section('content')
    <div class="relative h-64 md:h-80 rounded-sm overflow-hidden issue-card-cover mb-[-1px]"
         @if($issue->cover_image_path) style="background-image: url('{{ asset('storage/'.$issue->cover_image_path) }}');" @endif>
        @if($isCurrent)
            <span class="absolute top-4 left-4 text-xs uppercase font-heading bg-brand-500 text-white px-2 py-1">{{ __('Current') }}</span>
        @endif
    </div>

    <div class="bg-white rounded-sm shadow-sm p-6 md:p-10">
        <h1 class="text-2xl md:text-3xl text-brand-purple text-center mb-4">{{ $issue->title }}</h1>

        @if($issue->published_at)
            <p class="text-center text-sm text-brand-900/60 mb-8">
                {{ __('Publication date:') }} {{ $issue->published_at->format('d.m.Y') }}
            </p>
        @endif

        @if($issue->description)
            <div class="prose max-w-none text-brand-900/90 leading-relaxed mb-10">
                {!! $issue->description !!}
            </div>
        @endif

        @if($issue->files->isNotEmpty())
            <div class="flex flex-col gap-2 mb-10">
                @foreach($issue->files as $file)
                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" rel="noopener"
                       class="flex items-center gap-2 text-brand-600 hover:underline">
                        <span aria-hidden="true">&#128196;</span>
                        {{ $file->label }}
                    </a>
                @endforeach
            </div>
        @endif

        <h2 class="text-lg text-brand-purple mb-4">{{ __('Articles in this issue') }}</h2>

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
