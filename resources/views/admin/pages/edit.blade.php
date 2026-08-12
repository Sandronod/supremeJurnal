@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Edit') }}: {{ $page->title_en }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" x-data="{ tab: 'ka' }">
        @csrf
        @method('PUT')

        <div class="flex gap-2 mb-4">
            <button type="button" @click="tab = 'ka'" class="px-4 py-2 text-sm rounded-sm" :class="tab === 'ka' ? 'bg-brand-500 text-white' : 'bg-white text-brand-900'">ქართული</button>
            <button type="button" @click="tab = 'en'" class="px-4 py-2 text-sm rounded-sm" :class="tab === 'en' ? 'bg-brand-500 text-white' : 'bg-white text-brand-900'">English</button>
        </div>

        <div x-show="tab === 'ka'" x-cloak class="bg-white rounded-sm shadow-sm p-6 mb-4 space-y-4">
            <div>
                <label for="title_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
                <input id="title_ka" type="text" name="title_ka" value="{{ old('title_ka', $page->title_ka) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian text') }}</label>
                <input id="body_ka_input" type="hidden" name="body_ka" value="{{ old('body_ka', $page->body_ka) }}">
                <trix-editor input="body_ka_input" class="trix-content bg-white"></trix-editor>
            </div>
        </div>

        <div x-show="tab === 'en'" x-cloak class="bg-white rounded-sm shadow-sm p-6 mb-4 space-y-4">
            <div>
                <label for="title_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
                <input id="title_en" type="text" name="title_en" value="{{ old('title_en', $page->title_en) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-sm text-brand-900/70 mb-1">{{ __('English text') }}</label>
                <input id="body_en_input" type="hidden" name="body_en" value="{{ old('body_en', $page->body_en) }}">
                <trix-editor input="body_en_input" class="trix-content bg-white"></trix-editor>
            </div>
        </div>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
