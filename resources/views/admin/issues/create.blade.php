@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Create') }}: {{ __('Issues') }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.issues.store') }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm p-6 space-y-4">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="year" class="block text-sm text-brand-900/70 mb-1">{{ __('Year') }}</label>
                <input id="year" type="number" name="year" value="{{ old('year', date('Y')) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="number" class="block text-sm text-brand-900/70 mb-1">{{ __('Number') }}</label>
                <input id="number" type="text" name="number" value="{{ old('number') }}" placeholder="1" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label for="published_at" class="block text-sm text-brand-900/70 mb-1">Published at</label>
            <input id="published_at" type="date" name="published_at" value="{{ old('published_at') }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian text') }}</label>
                <input id="description_ka_input" type="hidden" name="description_ka" value="{{ old('description_ka') }}">
                <trix-editor input="description_ka_input" class="trix-content bg-white"></trix-editor>
            </div>
            <div>
                <label class="block text-sm text-brand-900/70 mb-1">{{ __('English text') }}</label>
                <input id="description_en_input" type="hidden" name="description_en" value="{{ old('description_en') }}">
                <trix-editor input="description_en_input" class="trix-content bg-white"></trix-editor>
            </div>
        </div>

        <div>
            <label for="pdf" class="block text-sm text-brand-900/70 mb-1">{{ __('Issue PDF') }}</label>
            <input id="pdf" type="file" name="pdf" accept="application/pdf"
                   class="block w-full text-sm">
        </div>

        <div>
            <label for="cover_image" class="block text-sm text-brand-900/70 mb-1">{{ __('Cover image') }}</label>
            <input id="cover_image" type="file" name="cover_image" accept="image/png,image/jpeg,image/webp"
                   class="block w-full text-sm">
        </div>

        <label class="flex items-center gap-2 text-sm text-brand-900/70">
            <input type="checkbox" name="is_current" value="1" {{ old('is_current') ? 'checked' : '' }}
                   class="rounded border-brand-900/20 text-brand-500 focus:ring-brand-500">
            {{ __('Set as current') }}
        </label>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
