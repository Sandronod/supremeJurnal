<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function current(): View
    {
        $issue = Issue::with('articles')->where('is_current', true)->firstOrFail();

        return view('issues.show', ['issue' => $issue, 'isCurrent' => true]);
    }

    public function archive(): View
    {
        $issues = Issue::orderByDesc('year')->orderByDesc('number')->get();

        return view('issues.archive', ['issues' => $issues]);
    }

    public function show(Issue $issue): View
    {
        $issue->load('articles');

        return view('issues.show', ['issue' => $issue, 'isCurrent' => $issue->is_current]);
    }
}
