@extends('layouts.public')

@section('title', __('Archive'))

@section('content')
    <div class="bg-white rounded-sm shadow-sm p-6 md:p-10">
        <h1 class="text-2xl md:text-3xl text-brand-purple mb-8">{{ __('Archive') }}</h1>

        @if($issues->isEmpty())
            <p class="text-brand-900/60">{{ __('No issues published yet.') }}</p>
        @else
            <ul class="divide-y divide-brand-900/10">
                @foreach($issues as $issue)
                    <li class="py-4 flex items-center justify-between gap-4">
                        <a href="{{ route('issues.show', $issue) }}" class="text-brand-900 hover:text-brand-500 font-medium">
                            {{ $issue->label }}
                        </a>
                        @if($issue->pdf_path)
                            <a href="{{ asset('storage/'.$issue->pdf_path) }}" target="_blank" rel="noopener"
                               class="text-sm text-brand-600 hover:underline shrink-0">
                                PDF
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
