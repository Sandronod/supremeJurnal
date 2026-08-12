<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));

        $articles = collect();

        if ($query !== '') {
            $articles = Article::with('issue')
                ->where('title_ka', 'like', "%{$query}%")
                ->orWhere('title_en', 'like', "%{$query}%")
                ->orderByDesc('id')
                ->get();
        }

        return view('search.results', ['query' => $query, 'articles' => $articles]);
    }
}
