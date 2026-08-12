<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Issue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('issue')->orderByDesc('id')->get();

        return view('admin.articles.index', ['articles' => $articles]);
    }

    public function create(): View
    {
        return view('admin.articles.create', ['issues' => $this->issueOptions()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateArticle($request);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('articles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('articles/covers', 'public');
        }

        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title_en']);

        unset($data['pdf'], $data['cover_image']);

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'article-created');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', ['article' => $article, 'issues' => $this->issueOptions()]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $this->validateArticle($request, $article);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('articles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('articles/covers', 'public');
        }

        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title_en']);

        unset($data['pdf'], $data['cover_image']);

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'article-updated');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'article-deleted');
    }

    private function issueOptions()
    {
        return Issue::orderByDesc('year')->orderByDesc('number')->get();
    }

    private function validateArticle(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'issue_id' => ['required', 'exists:issues,id'],
            'title_ka' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'authors' => ['required', 'string', 'max:255'],
            'abstract_ka' => ['nullable', 'string'],
            'abstract_en' => ['nullable', 'string'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', 'unique:articles,slug,'.($article->id ?? 'NULL')],
            'sort_order' => ['nullable', 'integer'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
