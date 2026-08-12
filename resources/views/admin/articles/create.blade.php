@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Create') }}: {{ __('Articles') }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm p-6 space-y-4">
        @csrf

        <div>
            <label for="issue_id" class="block text-sm text-brand-900/70 mb-1">{{ __('Issues') }}</label>
            <select id="issue_id" name="issue_id" required
                    class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
                <option value="">—</option>
                @foreach($issues as $issue)
                    <option value="{{ $issue->id }}" {{ old('issue_id') == $issue->id ? 'selected' : '' }}>{{ $issue->label }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="title_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
                <input id="title_ka" type="text" name="title_ka" value="{{ old('title_ka') }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="title_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
                <input id="title_en" type="text" name="title_en" value="{{ old('title_en') }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label for="authors" class="block text-sm text-brand-900/70 mb-1">{{ __('Authors') }}</label>
            <input id="authors" type="text" name="authors" value="{{ old('authors') }}" required
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="abstract_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Abstract') }} (ქართ.)</label>
                <textarea id="abstract_ka" name="abstract_ka" rows="4"
                          class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">{{ old('abstract_ka') }}</textarea>
            </div>
            <div>
                <label for="abstract_en" class="block text-sm text-brand-900/70 mb-1">{{ __('Abstract') }} (EN)</label>
                <textarea id="abstract_en" name="abstract_en" rows="4"
                          class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">{{ old('abstract_en') }}</textarea>
            </div>
        </div>

        <div>
            <label for="slug" class="block text-sm text-brand-900/70 mb-1">Slug</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="{{ __('auto-generated from English title if left blank') }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div>
            <label for="sort_order" class="block text-sm text-brand-900/70 mb-1">Sort order</label>
            <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div>
            <label for="pdf" class="block text-sm text-brand-900/70 mb-1">PDF</label>
            <input id="pdf" type="file" name="pdf" accept="application/pdf" class="block w-full text-sm">
        </div>

        <div>
            <label for="cover_image" class="block text-sm text-brand-900/70 mb-1">{{ __('Cover image') }}</label>
            <input id="cover_image" type="file" name="cover_image" accept="image/png,image/jpeg,image/webp" class="block w-full text-sm">
        </div>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
