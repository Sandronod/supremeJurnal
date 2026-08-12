<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Admin panel') }}@hasSection('title') — @yield('title')@endif</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="bg-brand-bg text-brand-900 font-sans antialiased min-h-screen flex">

    <aside class="w-56 shrink-0 bg-white border-r border-brand-900/10 min-h-screen">
        <div class="px-4 py-5 border-b border-brand-900/10">
            <a href="{{ route('admin.dashboard') }}" class="font-heading text-lg text-brand-900">{{ __('Admin panel') }}</a>
        </div>
        <nav class="p-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.dashboard') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Dashboard') }}</a>
            <a href="{{ route('admin.pages.index') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.pages.*') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Pages') }}</a>
            <a href="{{ route('admin.menu-items.index') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.menu-items.*') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Menu') }}</a>
            <a href="{{ route('admin.settings.edit') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.settings.*') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Settings') }}</a>
            <a href="{{ route('admin.issues.index') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.issues.*') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Issues') }}</a>
            <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-sm hover:bg-brand-bg {{ request()->routeIs('admin.articles.*') ? 'bg-brand-bg font-semibold' : '' }}">{{ __('Articles') }}</a>

            <form method="POST" action="{{ route('admin.logout') }}" class="pt-4 mt-4 border-t border-brand-900/10">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-sm hover:bg-brand-bg text-brand-900/70">{{ __('Log out') }}</button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 min-w-0">
        <main class="max-w-4xl mx-auto px-6 py-10">
            @if(session('status'))
                <div class="mb-6 bg-brand-500/10 text-brand-700 px-4 py-3 rounded-sm text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
