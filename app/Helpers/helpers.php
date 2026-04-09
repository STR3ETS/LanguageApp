<?php

if (!function_exists('trans_lang')) {
    /**
     * Translate a language name based on the language slug.
     */
    function trans_lang(string $slug): string
    {
        return __('ui.lang_' . strtolower($slug));
    }
}
