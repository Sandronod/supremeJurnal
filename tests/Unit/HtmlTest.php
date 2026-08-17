<?php

namespace Tests\Unit;

use App\Support\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    public function test_adds_target_blank_to_links_without_one(): void
    {
        $result = Html::externalLinksBlank('<p>See <a href="https://example.com">this</a>.</p>');

        $this->assertStringContainsString('<a target="_blank" rel="noopener" href="https://example.com">', $result);
    }

    public function test_does_not_duplicate_an_existing_target(): void
    {
        $html = '<a href="https://example.com" target="_self">link</a>';

        $this->assertSame($html, Html::externalLinksBlank($html));
    }

    public function test_passes_through_null_and_empty_strings(): void
    {
        $this->assertNull(Html::externalLinksBlank(null));
        $this->assertSame('', Html::externalLinksBlank(''));
    }

    public function test_adds_download_attribute_to_document_links(): void
    {
        $result = Html::externalLinksBlank('<a href="https://example.com/notes.doc">notes</a>');

        $this->assertStringContainsString('download', $result);
        $this->assertStringContainsString('href="https://example.com/notes.doc"', $result);
    }

    public function test_does_not_add_download_attribute_to_regular_page_links(): void
    {
        $result = Html::externalLinksBlank('<a href="https://example.com/about">about</a>');

        $this->assertStringNotContainsString('download', $result);
    }

    public function test_does_not_duplicate_an_existing_download_attribute(): void
    {
        $html = '<a href="https://example.com/notes.doc" download="custom-name.doc">notes</a>';

        $result = Html::externalLinksBlank($html);

        $this->assertSame(1, substr_count($result, 'download'));
    }
}
