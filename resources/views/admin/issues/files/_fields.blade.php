{{-- Shared fields for adding and editing an issue file; $file is null when adding. --}}
<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="label_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Georgian title') }}</label>
        <input id="label_ka" type="text" name="label_ka" value="{{ old('label_ka', $file?->label_ka) }}" required
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
    <div>
        <label for="label_en" class="block text-sm text-brand-900/70 mb-1">{{ __('English title') }}</label>
        <input id="label_en" type="text" name="label_en" value="{{ old('label_en', $file?->label_en) }}" required
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="author_ka" class="block text-sm text-brand-900/70 mb-1">{{ __('Author (Georgian)') }}</label>
        <input id="author_ka" type="text" name="author_ka" value="{{ old('author_ka', $file?->author_ka) }}"
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
    <div>
        <label for="author_en" class="block text-sm text-brand-900/70 mb-1">{{ __('Author (English)') }}</label>
        <input id="author_en" type="text" name="author_en" value="{{ old('author_en', $file?->author_en) }}"
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="pages" class="block text-sm text-brand-900/70 mb-1">{{ __('Pages') }}</label>
        <input id="pages" type="text" name="pages" value="{{ old('pages', $file?->pages) }}" placeholder="5-27"
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
    <div>
        <label for="sort_order" class="block text-sm text-brand-900/70 mb-1">{{ __('Sort order') }}</label>
        <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $file?->sort_order ?? $defaultSortOrder) }}"
               class="block w-full rounded-sm border-brand-900/20 focus:border-brand-500 focus:ring-brand-500">
    </div>
</div>

<div>
    <label for="file" class="block text-sm text-brand-900/70 mb-1">PDF</label>
    @if($file?->file_path)
        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" class="inline-block text-sm text-brand-600 hover:underline mb-2">{{ __('Download PDF') }}</a>
    @endif
    <input id="file" type="file" name="file" accept="application/pdf" class="block w-full text-sm">
    @if($file?->file_path)
        <p class="text-sm text-brand-900/50 mt-1">{{ __('Choose a file only to replace the current PDF.') }}</p>
        <label class="flex items-center gap-2 text-sm text-brand-900/70 mt-2">
            <input type="checkbox" name="remove_file" value="1" {{ old('remove_file') ? 'checked' : '' }}
                   class="rounded border-brand-900/20 text-brand-500 focus:ring-brand-500">
            {{ __('Remove the PDF (makes this a subheading)') }}
        </label>
    @else
        <p class="text-sm text-brand-900/50 mt-1">{{ __('Leave empty to add a subheading without pages or PDF.') }}</p>
    @endif
</div>
