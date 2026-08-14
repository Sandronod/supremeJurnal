<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Public routes carry the locale in the URL itself (e.g. /ka/contact)
        // so links are shareable regardless of session state. Routes without
        // that segment (admin) fall back to whatever was last set in session.
        $routeLocale = $request->route('locale');

        if (is_string($routeLocale) && in_array($routeLocale, ['ka', 'en'], true)) {
            $locale = $routeLocale;
            $request->session()->put('locale', $locale);
        } else {
            $locale = $request->session()->get('locale', config('app.locale'));

            if (! in_array($locale, ['ka', 'en'], true)) {
                $locale = config('app.locale');
            }
        }

        app()->setLocale($locale);

        // So that route()/url() calls elsewhere (menu links, redirects) that
        // don't explicitly pass "locale" still generate correct URLs for
        // routes that have a {locale} segment.
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
