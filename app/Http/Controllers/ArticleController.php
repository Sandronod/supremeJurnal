<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function show(Article $article): View
    {
        $article->load('issue');

        return view('articles.show', ['article' => $article]);
    }
}
