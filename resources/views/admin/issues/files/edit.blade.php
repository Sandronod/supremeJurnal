@extends('layouts.admin')

@section('content')
    <h1 class="font-heading text-xl text-brand-900 mb-2">{{ __('Edit') }}: {{ $file->label_ka }}</h1>
    <a href="{{ route('admin.issues.files.index', $issue) }}" class="text-sm text-brand-600 hover:underline">&larr; {{ __('Files') }}: {{ $issue->label }}</a>

    @if($errors->any())
        <div class="mt-4 mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.issues.files.update', [$issue, $file]) }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm p-6 space-y-4 mt-6">
        @csrf
        @method('PUT')

        @include('admin.issues.files._fields', ['file' => $file])

        <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-sm text-sm">
            {{ __('Save') }}
        </button>
    </form>
@endsection
