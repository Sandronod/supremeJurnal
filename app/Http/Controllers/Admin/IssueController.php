<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueController extends Controller
{
    public function index(): View
    {
        $issues = Issue::orderByDesc('year')->orderByDesc('number')->withCount('articles')->get();

        return view('admin.issues.index', ['issues' => $issues]);
    }

    public function create(): View
    {
        return view('admin.issues.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateIssue($request);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('issues', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('issues/covers', 'public');
        }

        unset($data['cover_image']);

        if (! empty($data['is_current'])) {
            Issue::where('is_current', true)->update(['is_current' => false]);
        }

        Issue::create($data);

        return redirect()->route('admin.issues.index')->with('status', 'issue-created');
    }

    public function edit(Issue $issue): View
    {
        return view('admin.issues.edit', ['issue' => $issue]);
    }

    public function update(Request $request, Issue $issue): RedirectResponse
    {
        $data = $this->validateIssue($request, $issue);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('issues', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('issues/covers', 'public');
        }

        unset($data['cover_image']);

        if (! empty($data['is_current'])) {
            Issue::where('is_current', true)->where('id', '!=', $issue->id)->update(['is_current' => false]);
        }

        $issue->update($data);

        return redirect()->route('admin.issues.index')->with('status', 'issue-updated');
    }

    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()->route('admin.issues.index')->with('status', 'issue-deleted');
    }

    public function setCurrent(Issue $issue): RedirectResponse
    {
        Issue::where('is_current', true)->update(['is_current' => false]);
        $issue->update(['is_current' => true]);

        return redirect()->route('admin.issues.index')->with('status', 'issue-set-current');
    }

    private function validateIssue(Request $request, ?Issue $issue = null): array
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'number' => ['required', 'string', 'max:50'],
            'description_ka' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_current' => ['nullable', 'boolean'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['is_current'] = $request->boolean('is_current');

        unset($data['pdf']);

        return $data;
    }
}
