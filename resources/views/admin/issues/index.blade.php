@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-xl text-brand-900">{{ __('Issues') }}</h1>
        <a href="{{ route('admin.issues.create') }}" class="bg-brand-500 hover:bg-brand-600 text-white text-sm px-4 py-2 rounded-sm">{{ __('Create') }}</a>
    </div>

    <div class="bg-white rounded-sm shadow-sm divide-y divide-brand-900/10">
        @forelse($issues as $issue)
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <span class="font-medium">{{ $issue->label }}</span>
                    @if($issue->is_current)
                        <span class="ml-2 text-xs uppercase font-heading bg-brand-500 text-white px-2 py-0.5 rounded-sm">{{ __('Current') }}</span>
                    @endif
                    <span class="ml-2 text-sm text-brand-900/50">{{ $issue->articles_count }} {{ __('Articles') }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    @unless($issue->is_current)
                        <form method="POST" action="{{ route('admin.issues.set-current', $issue) }}">
                            @csrf
                            <button type="submit" class="text-brand-600 hover:underline">{{ __('Set as current') }}</button>
                        </form>
                    @endunless
                    <a href="{{ route('admin.issues.edit', $issue) }}" class="text-brand-600 hover:underline">{{ __('Edit') }}</a>
                    <form method="POST" action="{{ route('admin.issues.destroy', $issue) }}" onsubmit="return confirm('{{ __('Delete') }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="px-6 py-4 text-brand-900/60">{{ __('No issues published yet.') }}</p>
        @endforelse
    </div>
@endsection
