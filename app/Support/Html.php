<?php

namespace App\Support;

class Html
{
    /**
     * Adds target="_blank" rel="noopener" to every <a> tag that doesn't
     * already declare a target — used on admin-authored rich text (Trix
     * has no per-link "open in new tab" toggle in its default toolbar).
     */
    public static function externalLinksBlank(?string $html): ?string
    {
        if (! $html) {
            return $html;
        }

        return preg_replace('/<a\s+(?![^>]*\btarget=)/i', '<a target="_blank" rel="noopener" ', $html);
    }
}
