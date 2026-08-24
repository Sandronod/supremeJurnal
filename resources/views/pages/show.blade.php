@extends('layouts.public')

@section('title', $page->title)

@section('content')
    <article class="p-6 md:p-10">
        @if($isHome ?? false)
            <div class="flex items-center justify-center gap-[50px] mb-6">
                <img src="{{ asset('imgs/frontLogo2.jpg') }}" alt="" class="h-20 w-auto">
                <img src="{{ asset('imgs/frontLogo1.jpg') }}" alt="" class="h-20 w-auto">
            </div>
        @endif
        <h1 class="text-2xl md:text-3xl text-black font-bold mb-6">{{ $page->title }}</h1>
        <div class="prose max-w-none prose-headings:font-bold prose-headings:text-black text-black leading-relaxed">
            {!! $page->body !!}
        </div>
    </article>
@endsection
