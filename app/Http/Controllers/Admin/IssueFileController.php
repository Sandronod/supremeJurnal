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
        $data = $request->validate([
            'label_ka' => ['required', 'string', 'max:255'],
            'label_en' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['issue_id'] = $issue->id;
        $data['file_path'] = $request->file('file')->store('issues/files', 'public');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['file']);

        IssueFile::create($data);

        return redirect()->route('admin.issues.files.index', $issue)->with('status', 'issue-file-added');
    }

    public function destroy(Issue $issue, IssueFile $file): RedirectResponse
    {
        abort_unless($file->issue_id === $issue->id, 404);

        $file->delete();

        return redirect()->route('admin.issues.files.index', $issue)->with('status', 'issue-file-deleted');
    }
}
