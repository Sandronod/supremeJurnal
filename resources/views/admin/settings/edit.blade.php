@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-6">{{ __('Settings') }}</h1>

    @if($errors->any())
        <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white rounded-sm shadow-sm p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="site_name_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
                <input id="site_name_ka" type="text" name="site_name_ka" value="{{ old('site_name_ka', $setting->site_name_ka) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="site_name_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
                <input id="site_name_en" type="text" name="site_name_en" value="{{ old('site_name_en', $setting->site_name_en) }}" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label for="issn" class="block text-sm text-brand-900/70 mb-1">ISSN</label>
            <input id="issn" type="text" name="issn" value="{{ old('issn', $setting->issn) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="copyright_text_ka" class="block text-sm text-brand-900/70 mb-1">Copyright (ქართ.)</label>
                <input id="copyright_text_ka" type="text" name="copyright_text_ka" value="{{ old('copyright_text_ka', $setting->copyright_text_ka) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="copyright_text_en" class="block text-sm text-brand-900/70 mb-1">Copyright (EN)</label>
                <input id="copyright_text_en" type="text" name="copyright_text_en" value="{{ old('copyright_text_en', $setting->copyright_text_en) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block text-sm text-brand-900/70 mb-1">{{ __('Phone') }}</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $setting->phone) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="email" class="block text-sm text-brand-900/70 mb-1">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email', $setting->email) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="address_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Address') }} (ქართ.)</label>
                <input id="address_ka" type="text" name="address_ka" value="{{ old('address_ka', $setting->address_ka) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
            <div>
                <label for="address_en" class="block text-sm text-brand-900/70 mb-1">{{ __('Address') }} (EN)</label>
                <input id="address_en" type="text" name="address_en" value="{{ old('address_en', $setting->address_en) }}"
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>
        </div>

        <div>
            <label for="map_embed_url" class="block text-sm text-brand-900/70 mb-1">Google Maps embed URL</label>
            <input id="map_embed_url" type="url" name="map_embed_url" value="{{ old('map_embed_url', $setting->map_embed_url) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <div>
            <label for="facebook_url" class="block text-sm text-brand-900/70 mb-1">Facebook URL</label>
            <input id="facebook_url" type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}"
                   class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
        </div>

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
