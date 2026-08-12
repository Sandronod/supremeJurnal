@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-xl text-brand-900">{{ __('Menu') }}</h1>
        <a href="{{ route('admin.menu-items.create') }}" class="bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">{{ __('Create') }}</a>
    </div>

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10">
        @forelse($items as $item)
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-medium">{{ $item->label_en }}</span>
                        <span class="ml-2 text-brand-900/40">/ {{ $item->label_ka }}</span>
                        <span class="ml-2 text-sm text-brand-900/50">{{ $item->route_name ?? $item->custom_url }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm shrink-0">
                        <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                        <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>

                @if($item->children->isNotEmpty())
                    <div class="mt-3 ml-6 space-y-2 border-l border-brand-900/10 pl-4">
                        @foreach($item->children as $child)
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium">{{ $child->label_en }}</span>
                                    <span class="ml-2 text-brand-900/40">/ {{ $child->label_ka }}</span>
                                    <span class="ml-2 text-sm text-brand-900/50">{{ $child->route_name ?? $child->custom_url }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-sm shrink-0">
                                    <a href="{{ route('admin.menu-items.edit', $child) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                                    <form method="POST" action="{{ route('admin.menu-items.destroy', $child) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <p class="px-6 py-4 text-brand-900/60">{{ __('No results found.') }}</p>
        @endforelse
    </div>
@endsection
