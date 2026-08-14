<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSetting?->site_name ?? config('app.name') }}@hasSection('title') — @yield('title')@endif</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-bg text-brand-900 font-sans antialiased flex min-h-screen flex-col">

    <header class="texture-header text-white">
        <span class="texture-square hidden sm:block" style="top: 0.75rem; right: 18%;" aria-hidden="true"></span>
        <span class="texture-square hidden sm:block" style="bottom: 0.5rem; left: 8%; width: 1rem; height: 1rem;" aria-hidden="true"></span>

        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-heading text-xl md:text-2xl tracking-wide">
                {{ $siteSetting?->site_name ?? config('app.name') }}
            </a>
            @if($siteSetting?->issn)
                <span class="hidden md:block text-sm text-white/70">ISSN {{ $siteSetting->issn }}</span>
            @endif
        </div>

        <nav class="border-t border-white/10" x-data="{ mobileOpen: false }">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-between py-2">
                    <button class="md:hidden text-white" @click="mobileOpen = !mobileOpen" aria-label="Menu">
                        &#9776;
                    </button>

                    <ul class="hidden md:flex items-center gap-6 text-sm font-heading uppercase tracking-wide">
                        @foreach($menuTree as $item)
                            @if($item->children->isNotEmpty())
                                <li class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <a href="{{ $item->resolved_url }}" class="py-3 inline-block hover:text-brand-500">{{ $item->label }}</a>
                                    <div x-show="open" x-cloak class="absolute left-0 top-full bg-white text-brand-900 shadow-lg min-w-[220px] normal-case font-sans z-20">
                                        @foreach($item->children as $child)
                                            <a href="{{ $child->resolved_url }}" class="block px-4 py-3 hover:bg-brand-bg">{{ $child->label }}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @else
                                <li><a href="{{ $item->resolved_url }}" class="py-3 inline-block hover:text-brand-500">{{ $item->label }}</a></li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="hidden md:flex items-center gap-4">
                        <form action="{{ route('search') }}" method="GET" class="flex items-center">
                            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('Search articles...') }}"
                                   class="rounded-l-sm border-0 text-sm text-brand-900 px-3 py-1.5 focus:ring-2 focus:ring-brand-500">
                            <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-white text-sm px-3 py-1.5 rounded-r-sm">
                                {{ __('Search') }}
                            </button>
                        </form>
                        <div class="flex items-center gap-1 text-sm font-heading">
                            <a href="{{ route('lang', 'ka') }}" class="px-1 {{ app()->getLocale() === 'ka' ? 'underline' : 'text-white/60' }}">GEO</a>
                            /
                            <a href="{{ route('lang', 'en') }}" class="px-1 {{ app()->getLocale() === 'en' ? 'underline' : 'text-white/60' }}">ENG</a>
                        </div>
                    </div>
                </div>

                <div x-show="mobileOpen" x-cloak class="md:hidden pb-4 space-y-1 text-sm">
                    @foreach($menuTree as $item)
                        <a href="{{ $item->resolved_url }}" class="block py-2">{{ $item->label }}</a>
                        @foreach($item->children as $child)
                            <a href="{{ $child->resolved_url }}" class="block py-2 pl-4">{{ $child->label }}</a>
                        @endforeach
                    @endforeach
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('lang', 'ka') }}" class="underline">GEO</a>
                        <a href="{{ route('lang', 'en') }}" class="underline">ENG</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-10">
        @yield('content')
    </main>

    <footer class="texture-footer mt-auto">
        <span class="texture-square hidden sm:block" style="top: 0.75rem; left: 12%;" aria-hidden="true"></span>
        <span class="texture-square hidden sm:block" style="bottom: 0.75rem; right: 15%; width: 1.25rem; height: 1.25rem;" aria-hidden="true"></span>

        <div class="max-w-6xl mx-auto px-4 py-8 text-sm text-white/90 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <p>{{ $siteSetting?->copyright_text ?? '' }}</p>
            <div class="flex gap-4">
                @if($siteSetting?->email)
                    <a href="mailto:{{ $siteSetting->email }}" class="hover:text-white">{{ $siteSetting->email }}</a>
                @endif
                @if($siteSetting?->phone)
                    <span>{{ $siteSetting->phone }}</span>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>
