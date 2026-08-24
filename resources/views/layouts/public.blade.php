<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSetting?->site_name ?? config('app.name') }}@hasSection('title') — @yield('title')@endif</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="body-texture text-brand-900 font-sans antialiased flex min-h-screen flex-col">

    <header class="texture-header text-white">
        <div class="max-w-6xl mx-auto relative h-[58px] md:h-[74px]">
            <a href="{{ route('home') }}" class="absolute left-4 top-[5px]">
                <img src="{{ asset('imgs/geoLogo.jpg') }}" alt="{{ $siteSetting?->site_name_ka }}" class="h-12 md:h-16 w-auto">
            </a>
            <a href="{{ route('home') }}" class="absolute right-4 bottom-[5px]">
                <img src="{{ asset('imgs/engLogo.jpg') }}" alt="{{ $siteSetting?->site_name_en }}" class="h-12 md:h-16 w-auto">
            </a>
        </div>

        <nav class="border-t border-white/10" x-data="{ mobileOpen: false }">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-between py-3">
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
                            <a href="{{ $localizedUrls['ka'] }}" class="px-1 {{ app()->getLocale() === 'ka' ? 'underline' : 'text-white/60' }}">GEO</a>
                            /
                            <a href="{{ $localizedUrls['en'] }}" class="px-1 {{ app()->getLocale() === 'en' ? 'underline' : 'text-white/60' }}">ENG</a>
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
                        <a href="{{ $localizedUrls['ka'] }}" class="underline">GEO</a>
                        <a href="{{ $localizedUrls['en'] }}" class="underline">ENG</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-10">
        @yield('content')
    </main>

    <footer class="texture-footer mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 mb-8 text-sm">
                @foreach($menuTree as $item)
                    <div>
                        <a href="{{ $item->resolved_url }}" class="font-heading uppercase tracking-wide text-white hover:text-white/80">{{ $item->label }}</a>
                        @if($item->children->isNotEmpty())
                            <ul class="mt-2 space-y-1 text-white/70">
                                @foreach($item->children as $child)
                                    <li><a href="{{ $child->resolved_url }}" class="hover:text-white">{{ $child->label }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="border-t border-white/15 pt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-white/90">
                <p>{{ $siteSetting?->copyright_text ?? '' }}</p>
                <div class="flex flex-col sm:flex-row gap-1 sm:gap-4">
                    @if($siteSetting?->email)
                        <a href="mailto:{{ $siteSetting->email }}" class="hover:text-white">{{ $siteSetting->email }}</a>
                    @endif
                    @if($siteSetting?->address)
                        <span>{{ $siteSetting->address }}</span>
                    @endif
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
