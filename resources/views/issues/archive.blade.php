@extends('layouts.public')

@section('title', __('Archive'))

@section('content')
    <h1 class="text-2xl md:text-3xl text-brand-purple mb-8">{{ __('Archive') }}</h1>

    @if($issues->isEmpty())
        <div class="bg-white rounded-sm shadow-sm p-6 md:p-10">
            <p class="text-brand-900/60">{{ __('No issues published yet.') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($issues as $issue)
                <a href="{{ route('issues.show', $issue) }}" class="block bg-white rounded-sm shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="relative @unless($issue->cover_image_path) h-48 issue-card-cover @endunless">
                        @if($issue->cover_image_path)
                            <img src="{{ asset('storage/'.$issue->cover_image_path) }}" alt="" class="block w-full h-auto">
                        @endif
                        @if($issue->is_current)
                            <span class="absolute top-3 left-3 text-xs uppercase font-heading bg-brand-500 text-white px-2 py-1">{{ __('Current') }}</span>
                        @endif
                        <span class="absolute top-3 right-3 bg-brand-purple/80 text-white text-xs font-heading px-2 py-1 rounded-sm">#{{ $issue->number }}</span>
                    </div>
                    <div class="p-5">
                        <h2 class="font-heading text-brand-purple text-base leading-snug mb-4">{{ $issue->title }}</h2>
                        <span class="inline-block bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">{{ __('View in full') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
