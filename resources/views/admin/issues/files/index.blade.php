@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-2">{{ __('Files') }}: {{ $issue->label }}</h1>
    <a href="{{ route('admin.issues.edit', $issue) }}" class="text-sm text-brand-600 hover:underline">&larr; {{ __('Edit') }}: {{ $issue->label }}</a>

    @if($errors->any())
        <div class="mt-4 mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10 mt-6 mb-8">
        @forelse($files as $file)
            <div class="flex items-center justify-between gap-4 px-6 py-4">
                <div>
                    @if($file->author_ka || $file->author_en)
                        <p class="text-sm italic text-brand-900/70">
                            {{ $file->author_ka }}@if($file->author_en) <span class="text-brand-900/40">/ {{ $file->author_en }}</span>@endif
                        </p>
                    @endif
                    <p>
                        @unless($file->file_path)
                            <span class="text-xs uppercase bg-brand-900/10 text-brand-900/70 px-1.5 py-0.5 rounded-sm mr-1">{{ __('Subheading') }}</span>
                        @endunless
                        <span class="font-medium">{{ $file->label_ka }}</span>
                        <span class="text-brand-900/40">/ {{ $file->label_en }}</span>
                    </p>
                    @if($file->pages)
                        <p class="text-sm text-brand-900/50">{{ __('Pages') }}: {{ $file->pages }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-3 text-sm shrink-0">
                    @if($file->file_path)
                        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="text-brand-600 hover:underline">{{ __('Download PDF') }}</a>
                    @endif
                    <a href="{{ route('admin.issues.files.edit', [$issue, $file]) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                    <form method="POST" action="{{ route('admin.issues.files.destroy', [$issue, $file]) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
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

    <h2 class="font-heading text-lg text-brand-900 mb-4">{{ __('Create') }}</h2>

    <form method="POST" action="{{ route('admin.issues.files.store', $issue) }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm p-6 space-y-4">
        @csrf

        @include('admin.issues.files._fields', ['file' => null, 'defaultSortOrder' => $files->count() + 1])

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
