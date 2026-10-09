@extends('layouts.public')

@section('title', $issue->label)

@section('content')
    {{-- An uploaded cover is shown whole at its own proportions, never cropped. --}}
    <div class="relative rounded-sm overflow-hidden mb-[-1px] @unless($issue->cover_image_path) h-64 md:h-80 issue-card-cover @endunless">
        @if($issue->cover_image_path)
            <img src="{{ asset('storage/'.$issue->cover_image_path) }}" alt="" class="block w-full h-auto">
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

        @if($issue->pdf_path || $issue->files->isNotEmpty())
            <div class="mb-10">
                <h2 class="text-lg text-brand-purple font-bold mb-4">
                    # {{ $issue->number }} {{ $issue->year }}
                    @if($issue->pdf_path)
                        &ndash;
                        <a href="{{ asset('storage/'.$issue->pdf_path) }}" target="_blank" rel="noopener"
                           class="text-brand-600 hover:underline">[PDF]</a>
                    @endif
                </h2>

                @if($issue->files->isNotEmpty())
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-brand-900/30 text-sm text-brand-900/70">
                                <th class="font-medium py-2 pr-4">{{ __('Contents') }}</th>
                                <th class="font-medium py-2 pr-4 whitespace-nowrap">{{ __('Page') }}</th>
                                <th class="font-medium py-2">PDF</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-900/10">
                            @foreach($issue->files as $file)
                                @unless($file->file_path)
                                    <tr>
                                        <td colspan="3" class="pt-5 pb-2 font-bold text-brand-900">{{ $file->label }}</td>
                                    </tr>
                                    @continue
                                @endunless
                                <tr class="align-top">
                                    <td class="py-3 pr-4">
                                        @if($file->author)
                                            <p class="italic text-brand-900/70">{{ $file->author }}</p>
                                        @endif
                                        <p class="text-brand-900">{{ $file->label }}</p>
                                    </td>
                                    <td class="py-3 pr-4 whitespace-nowrap text-brand-900/70">{{ $file->pages }}</td>
                                    <td class="py-3">
                                        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" rel="noopener"
                                           class="text-brand-600 hover:underline">[PDF]</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endif

        <a href="{{ route('issues.archive') }}" class="inline-block mt-8 text-sm text-brand-600 hover:underline">
            &larr; {{ __('Back to archive') }}
        </a>
    </div>
@endsection
