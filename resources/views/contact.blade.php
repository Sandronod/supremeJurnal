@extends('layouts.public')

@section('title', __('Contact'))

@section('content')
    <div class="p-6 md:p-10">
        <h1 class="text-2xl md:text-3xl text-brand-purple mb-8">{{ __('Contact') }}</h1>

        <dl class="space-y-4 mb-8">
            @if($setting->phone)
                <div>
                    <dt class="text-sm uppercase font-heading text-brand-900/60">{{ __('Phone') }}</dt>
                    <dd class="text-brand-900">{{ $setting->phone }}</dd>
                </div>
            @endif
            @if($setting->email)
                <div>
                    <dt class="text-sm uppercase font-heading text-brand-900/60">{{ __('Email') }}</dt>
                    <dd class="text-brand-900"><a href="mailto:{{ $setting->email }}" class="hover:underline">{{ $setting->email }}</a></dd>
                </div>
            @endif
            @if($setting->address)
                <div>
                    <dt class="text-sm uppercase font-heading text-brand-900/60">{{ __('Address') }}</dt>
                    <dd class="text-brand-900">{{ $setting->address }}</dd>
                </div>
            @endif
        </dl>

        @if($setting->map_embed_url)
            <div class="aspect-video w-full">
                <iframe src="{{ $setting->map_embed_url }}" class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        @endif
    </div>
@endsection
