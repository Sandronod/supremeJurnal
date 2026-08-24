@extends('layouts.public')

@section('title', $page->title)

@section('content')
    <article class="p-6 md:p-10">
        <h1 class="text-2xl md:text-3xl text-black font-bold mb-6">{{ $page->title }}</h1>
        <div class="prose max-w-none prose-headings:font-bold prose-headings:text-black text-black leading-relaxed">
            {!! $page->body !!}
        </div>
    </article>
@endsection
