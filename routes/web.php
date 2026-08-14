<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IssueController as AdminIssueController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route prefix (see config/app.php "route_prefix" — empty in normal use)
|--------------------------------------------------------------------------
*/

Route::prefix(config('app.route_prefix'))->group(function () {

    /*
    |----------------------------------------------------------------------
    | Public routes — locale is part of the URL (e.g. /ka/contact,
    | /en/contact) so pages are shareable/bookmarkable in a specific
    | language rather than depending on a session cookie.
    |----------------------------------------------------------------------
    */

    // No locale segment yet: send the visitor to their session/browser
    // default locale so "/" (or "/journal") always resolves to a real page.
    Route::get('/', function () {
        $locale = session('locale', config('app.locale'));

        if (! in_array($locale, ['ka', 'en'], true)) {
            $locale = config('app.locale');
        }

        return redirect()->route('home', ['locale' => $locale]);
    });

    Route::prefix('{locale}')->where(['locale' => 'ka|en'])->group(function () {
        Route::get('/', [PageController::class, 'home'])->name('home');

        Route::get('/about/{slug}', [PageController::class, 'show'])
            ->whereIn('slug', ['aims-scope', 'review-ethics'])
            ->name('about.show');

        Route::get('/editorial-board', [PageController::class, 'show'])
            ->defaults('slug', 'editorial-board')
            ->name('editorial-board');

        Route::get('/for-authors', [PageController::class, 'show'])
            ->defaults('slug', 'for-authors')
            ->name('for-authors');

        Route::get('/issues/current', [IssueController::class, 'current'])->name('issues.current');
        Route::get('/issues', [IssueController::class, 'archive'])->name('issues.archive');
        Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issues.show');

        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::get('/search', SearchController::class)->name('search');
    });

    /*
    |----------------------------------------------------------------------
    | Admin routes — no locale segment; the admin UI's own language follows
    | the session (set implicitly whenever an admin visits the public site).
    |----------------------------------------------------------------------
    */

    require __DIR__.'/auth.php';

    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::resource('menu-items', AdminMenuItemController::class)->except(['show']);

        Route::post('/issues/{issue}/set-current', [AdminIssueController::class, 'setCurrent'])->name('issues.set-current');
        Route::resource('issues', AdminIssueController::class)->except(['show']);

        Route::resource('articles', AdminArticleController::class)->except(['show']);
    });

});
