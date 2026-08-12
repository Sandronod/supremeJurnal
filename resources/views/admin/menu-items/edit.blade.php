@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Edit') }}: {{ $item->label_en }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.menu-items.update', $item) }}" class="bg-white rounded-sm shadow-sm p-6 space-y-4"
          x-data="{ linkType: '{{ old('link_type', $item->custom_url ? 'custom' : 'internal') }}' }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="label_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
                <input id="label_ka" type="text" name="label_ka" value="{{ old('label_ka', $item->label_ka) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="label_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
                <input id="label_en" type="text" name="label_en" value="{{ old('label_en', $item->label_en) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label class="block text-sm text-brand-900/70 mb-1">{{ __('Link type') }}</label>
            <div class="flex gap-4 text-sm">
                <label class="flex items-center gap-2">
                    <input type="radio" name="link_type" value="internal" x-model="linkType" class="text-brand-500 focus:ring-brand-500">
                    {{ __('Internal page') }}
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="link_type" value="custom" x-model="linkType" class="text-brand-500 focus:ring-brand-500">
                    {{ __('Custom URL') }}
                </label>
            </div>
        </div>

        <div x-show="linkType === 'internal'">
            <label for="internal_target" class="block text-sm text-brand-900/70 mb-1">{{ __('Internal page') }}</label>
            <select id="internal_target" name="internal_target"
                    class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
                @foreach($targets as $key => $target)
                    <option value="{{ $key }}" {{ old('internal_target', $selectedTarget) === $key ? 'selected' : '' }}>{{ $target['label_en'] }} / {{ $target['label_ka'] }}</option>
                @endforeach
            </select>
        </div>

        <div x-show="linkType === 'custom'">
            <label for="custom_url" class="block text-sm text-brand-900/70 mb-1">{{ __('Custom URL') }}</label>
            <input id="custom_url" type="text" name="custom_url" value="{{ old('custom_url', $item->custom_url) }}" placeholder="https://..."
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div>
            <label for="parent_id" class="block text-sm text-brand-900/70 mb-1">{{ __('Parent item') }}</label>
            <select id="parent_id" name="parent_id"
                    class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
                <option value="">{{ __('Top-level (no parent)') }}</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ (string) old('parent_id', $item->parent_id) === (string) $parent->id ? 'selected' : '' }}>{{ $parent->label_en }} / {{ $parent->label_ka }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sort_order" class="block text-sm text-brand-900/70 mb-1">Sort order</label>
            <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
