<?php

namespace App\Support;

class Html
{
    /**
     * File extensions that browsers try to render/navigate to instead of
     * downloading when just opened in a link — force a real download for
     * these instead.
     */
    private const DOWNLOADABLE_EXTENSIONS = 'pdf|docx?|xlsx?|pptx?|zip|rar|7z|csv|txt';

    /**
     * Adds target="_blank" rel="noopener" to every <a> tag that doesn't
     * already declare a target — used on admin-authored rich text (Trix
     * has no per-link "open in new tab" toggle in its default toolbar).
     *
     * Also adds the "download" attribute when the link points at a file
     * (PDF, DOC, ZIP, ...) so it downloads instead of opening a blank tab
     * the browser can't render — Trix has no UI for this either.
     */
    public static function externalLinksBlank(?string $html): ?string
    {
        if (! $html) {
            return $html;
        }

        return preg_replace_callback('/<a\s+([^>]*)>/i', function (array $matches) {
            $attrs = $matches[1];

            if (! preg_match('/\btarget=/i', $attrs)) {
                $attrs = 'target="_blank" rel="noopener" '.$attrs;
            }

            if (! preg_match('/\bdownload\b/i', $attrs)
                && preg_match('/href="([^"]+)"/i', $attrs, $hrefMatch)
                && preg_match('/\.('.self::DOWNLOADABLE_EXTENSIONS.')(\?.*)?$/i', $hrefMatch[1])) {
                $attrs = 'download '.$attrs;
            }

            return '<a '.$attrs.'>';
        }, $html);
    }
}
