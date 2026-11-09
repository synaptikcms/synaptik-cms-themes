<?php
/**
 * Axion Theme — functions.php
 *
 * Theme-specific helpers and i18n loader. Loaded by the CMS after all core
 * libraries. Card HTML is overridden through partials/ rather than redefining
 * core functions, which would trigger a fatal error.
 */

// ---------------------------------------------------------------------------
// Theme i18n — merge theme-specific strings into the active language pack.
//
// The theme ships its own lang/{locale}.json files so these strings do not
// pollute the CMS core language files. They are merged here, after lang_load()
// has already populated $_LANG_STRINGS, so core keys always take priority.
// ---------------------------------------------------------------------------
(function () {
    $locale    = lang_current();
    $themeDir  = __DIR__ . '/lang/';
    $themeLang = $themeDir . $locale . '.json';

    // Fall back to English if the requested locale does not exist for this theme.
    if (!file_exists($themeLang)) {
        $themeLang = $themeDir . 'en.json';
    }

    if (!file_exists($themeLang)) {
        return;
    }

    $strings = json_decode(file_get_contents($themeLang), true);
    if (!is_array($strings)) {
        return;
    }

    // Remove internal metadata key before merging.
    unset($strings['_meta']);

    // Ensure the CMS core strings are loaded first — lang_load() is idempotent.
    // Theme strings are merged underneath: core keys always take priority.
    $core = lang_load();
    $GLOBALS['_LANG_STRINGS'] = array_merge($strings, $core);
})();
