<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Under subfolder deployments, PHP's SCRIPT_NAME reflects the internally
        // rewritten path (e.g. /journal/public), which Laravel would otherwise use
        // as the base for url()/route() generation. Forcing the root fixes that —
        // but when ROUTE_PREFIX is also set, routes/web.php already adds that
        // segment via Route::prefix(), so here we force only scheme+host to avoid
        // doubling it (e.g. /journal/journal/...). ASSET_URL is unaffected: assets
        // aren't registered routes, so they still need the full path with prefix.
        $appUrl = config('app.url');

        if (config('app.route_prefix')) {
            $parsed = parse_url($appUrl);
            $appUrl = ($parsed['scheme'] ?? 'https').'://'.($parsed['host'] ?? '')
                .(isset($parsed['port']) ? ':'.$parsed['port'] : '');
        }

        URL::forceRootUrl($appUrl);

        if (str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }

        View::composer('layouts.public', function ($view) {
            $view->with('siteSetting', Setting::query()->first());
            $view->with('menuTree', MenuItem::whereNull('parent_id')->with('children')->orderBy('sort_order')->get());
            $view->with('localizedUrls', $this->localizedUrls());
        });
    }

    /**
     * URLs for the current page in each supported locale, so the GEO/ENG
     * switcher links to the same page translated rather than always
     * bouncing to the homepage.
     *
     * @return array<string, string>
     */
    private function localizedUrls(): array
    {
        $route = Route::current();
        $query = request()->getQueryString();
        $urls = [];

        foreach (['ka', 'en'] as $locale) {
            if ($route && in_array('locale', $route->parameterNames(), true)) {
                // Only pass parameters that are real URI segments for this route —
                // route()->parameters() also includes ->defaults() values (e.g.
                // "slug" on /editorial-board), which would otherwise leak in as a
                // stray ?slug=... query string since they have no {slug} segment.
                $uriParams = array_intersect_key($route->parameters(), array_flip($route->parameterNames()));
                $url = route($route->getName(), array_merge($uriParams, ['locale' => $locale]));
            } else {
                $url = route('home', ['locale' => $locale]);
            }

            $urls[$locale] = $query ? "{$url}?{$query}" : $url;
        }

        return $urls;
    }
}
