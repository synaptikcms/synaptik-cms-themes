<?php
/**
 * Atrium Theme — functions.php
 *
 * Theme-specific helpers and i18n loader. Loaded by the CMS after all core
 * libraries. Card HTML is overridden through partials/ rather than redefining
 * core functions, which would trigger a fatal error.
 *
 * Helpers are prefixed df_ in homage to the author rather than the theme
 * name, so they remain stable if the theme is ever forked or renamed.
 */

// ---------------------------------------------------------------------------
// Theme i18n — merge theme-specific strings into the active language pack.
//
// The theme ships its own lang/{locale}.json files so these strings do not
// pollute the CMS core language files. They are merged here, after lang_load()
// has already populated $_LANG_STRINGS, so core keys always take priority
// and no cache invalidation of the core cache is needed.
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

    // Ensure the CMS core strings are loaded first — lang_load() is idempotent
    // and returns immediately if $_LANG_STRINGS is already populated.
    // Theme strings are merged on top: core keys always take priority.
    $core = lang_load();
    $GLOBALS['_LANG_STRINGS'] = array_merge($strings, $core);
})();


// ---------------------------------------------------------------------------
// Body class helper
// ---------------------------------------------------------------------------

/**
 * Return space-separated CSS body classes for the current request.
 * Used to provide layout context to CSS based on page type.
 *
 * @return string
 */
function df_body_class(): string
{
    $type = $_GET['type'] ?? '';
    $slug = $_GET['slug'] ?? '';

    $classes = ['theme-atrium'];

    if ($type === '' && $slug === '') {
        $classes[] = 'is-home';
    } elseif ($type !== '' && $slug === '') {
        $classes[] = 'is-list';
        $classes[] = 'is-list--' . htmlspecialchars($type, ENT_QUOTES);
    } else {
        $classes[] = 'is-single';
        if ($type !== '') {
            $classes[] = 'is-single--' . htmlspecialchars($type, ENT_QUOTES);
        }
    }

    return implode(' ', $classes);
}
