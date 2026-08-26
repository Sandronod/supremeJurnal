@extends('layouts.public')

@section('title', $page->title)

@section('content')
    <article class="p-6 md:p-10">
        @if($isHome ?? false)
            <div class="flex items-center justify-center gap-[50px] mb-6">
                <img src="{{ asset('imgs/Logo_of_the_Supreme_Court_of_Georgia.png') }}" alt="" class="h-[130px] w-auto">
                <img src="{{ asset('imgs/frontLogo2.jpg') }}" alt="" class="h-[100px] w-auto">
            </div>
        @endif
        <h1 class="text-2xl md:text-3xl text-black font-bold mb-6">{{ $page->title }}</h1>
        <div class="prose max-w-none prose-headings:font-bold prose-headings:text-black prose-strong:font-heading prose-strong:uppercase prose-strong:tracking-wide text-black leading-relaxed">
            {!! $page->body !!}
        </div>
    </article>
@endsection
