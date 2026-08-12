<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Log in') }} — {{ __('Admin panel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-bg text-brand-900 font-sans antialiased min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-white rounded-sm shadow-sm p-8">
        <h1 class="font-heading text-xl text-brand-900 mb-6 text-center">{{ __('Admin panel') }}</h1>

        @if($errors->any())
            <div class="mb-4 bg-red-50 text-red-700 text-sm px-4 py-3 rounded-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm text-brand-900/70 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>

            <div>
                <label for="password" class="block text-sm text-brand-900/70 mb-1">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required
                       class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
            </div>

            <label class="flex items-center gap-2 text-sm text-brand-900/70">
                <input type="checkbox" name="remember" class="rounded border-brand-900/20 text-brand-500 focus:ring-brand-500">
                {{ __('Remember me') }}
            </label>

            <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white py-2 rounded-sm">
                {{ __('Log in') }}
            </button>
        </form>
    </div>

</body>
</html>
