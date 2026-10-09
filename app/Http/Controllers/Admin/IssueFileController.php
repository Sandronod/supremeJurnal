<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\IssueFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueFileController extends Controller
{
    public function index(Issue $issue): View
    {
        return view('admin.issues.files.index', ['issue' => $issue, 'files' => $issue->files]);
    }

    public function store(Request $request, Issue $issue): RedirectResponse
    {
        $data = $this->validateFile($request);

        $data['issue_id'] = $issue->id;
        // Without a PDF the entry is a subheading in the contents list.
        $data['file_path'] = $request->hasFile('file') ? $request->file('file')->store('issues/files', 'public') : null;

        IssueFile::create($data);

        return redirect()->route('admin.issues.files.index', $issue)->with('status', 'issue-file-added');
    }

    public function edit(Issue $issue, IssueFile $file): View
    {
        abort_unless($file->issue_id === $issue->id, 404);

        return view('admin.issues.files.edit', ['issue' => $issue, 'file' => $file]);
    }

    public function update(Request $request, Issue $issue, IssueFile $file): RedirectResponse
    {
        abort_unless($file->issue_id === $issue->id, 404);

        $data = $this->validateFile($request);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('issues/files', 'public');
        } elseif ($request->boolean('remove_file')) {
            // Dropping the PDF turns the entry into a subheading.
            $data['file_path'] = null;
        }

        $file->update($data);

        return redirect()->route('admin.issues.files.index', $issue)->with('status', 'issue-file-updated');
    }

    public function destroy(Issue $issue, IssueFile $file): RedirectResponse
    {
        abort_unless($file->issue_id === $issue->id, 404);

        $file->delete();

        return redirect()->route('admin.issues.files.index', $issue)->with('status', 'issue-file-deleted');
    }

    private function validateFile(Request $request): array
    {
        $data = $request->validate([
            'label_ka' => ['required', 'string', 'max:255'],
            'label_en' => ['required', 'string', 'max:255'],
            'author_ka' => ['nullable', 'string', 'max:255'],
            'author_en' => ['nullable', 'string', 'max:255'],
            'pages' => ['nullable', 'string', 'max:50'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['file']);

        return $data;
    }
}
