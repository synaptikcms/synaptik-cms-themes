<?php
/**
 * Vitae Theme — functions.php
 *
 * 1. Loads theme-specific i18n strings from lang/{locale}.json.
 * 2. Reads vitae_options from theme.json and exposes them via vitae_option().
 */

// ── i18n ─────────────────────────────────────────────────────────────────────
(function () {
    $locale    = lang_current();
    $themeDir  = __DIR__ . '/lang/';
    $themeLang = $themeDir . $locale . '.json';

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

    unset($strings['_meta']);

    $core = lang_load();
    $GLOBALS['_LANG_STRINGS'] = array_merge($strings, $core);
})();

// ── Theme options from theme.json ─────────────────────────────────────────────
(function () {
    $themeJson = __DIR__ . '/theme.json';
    if (!file_exists($themeJson)) {
        $GLOBALS['_VITAE_OPTIONS'] = [];
        return;
    }

    $decoded = json_decode(file_get_contents($themeJson), true);
    $GLOBALS['_VITAE_OPTIONS'] = (is_array($decoded) && isset($decoded['vitae_options']))
        ? $decoded['vitae_options']
        : [];
})();

/**
 * Returns a Vitae theme option from theme.json → vitae_options.
 *
 * @param string $key     Option key (e.g. 'show_availability')
 * @param mixed  $default Fallback value if the key is absent
 * @return mixed
 */
function vitae_option(string $key, $default = null)
{
    return $GLOBALS['_VITAE_OPTIONS'][$key] ?? $default;
}
