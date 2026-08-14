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
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <span class="font-medium">{{ $file->label_en }}</span>
                    <span class="text-brand-900/40">/ {{ $file->label_ka }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm shrink-0">
                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="text-brand-600 hover:underline">{{ __('Download PDF') }}</a>
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

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="label_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
                <input id="label_ka" type="text" name="label_ka" value="{{ old('label_ka') }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="label_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
                <input id="label_en" type="text" name="label_en" value="{{ old('label_en') }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label for="file" class="block text-sm text-brand-900/70 mb-1">PDF</label>
            <input id="file" type="file" name="file" accept="application/pdf" required class="block w-full text-sm">
        </div>

        <div>
            <label for="sort_order" class="block text-sm text-brand-900/70 mb-1">Sort order</label>
            <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
