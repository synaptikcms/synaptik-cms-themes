# Synaptik-Docs Theme — Changelog

## [1.1.8] — 2026-08-31

### Fixed

- **Inter font preload warning in the console** — the preload link's URL carried a cache-busting query string that the CSS's `@font-face` rule never requested, so the browser flagged the font as "preloaded but not used" and fetched it a second time under a different URL.
- **Recent Doc Updates showed the category slug instead of its name** — the homepage's recent-articles list printed the raw stored category slug (e.g. `theming`) instead of its display name. Now resolves the name from the categories store, same as core's article/page category badge.

## [1.1.7] — 2026-08-27

- **Pagination fade transition merged into this theme's own script** — previously loaded from a separate core file (`assets/js/page-transitions.js`) on every theme regardless of whether it used it; now part of this theme's own `script.js`, same effect, one less request.

# 

- **Topbar search now uses the site-wide renamed-type mechanism** — the theme's own content-type labels for search result badges are no longer built locally; it reads the same `CMS_TYPE_LABELS` data every other theme uses, so it stays correct without any theme-specific code.

## [1.1.6] — 2026-08-24

### Changed

- **Syntax highlighting is now supplied entirely by core** — `render_hljs_scripts()` (`core/render/tf-page.php`) detects a code block server-side and loads highlight.js itself, with proper SRI hashes, instead of the theme fetching it separately. Removed this theme's own `<script>` tags for `highlight.min.js`/`languages/php.min.js` from `footer.php`.
- Removed the duplicate `hljs.highlightElement()` init loop from `js/script.js` — the same pass now runs once, from core's shared `assets/js/hljs-init.js`.
- The theme's own `.hljs` CSS palette in `style.css` is untouched and still applies — core's shared fallback stylesheet detects it and skips itself for this theme.
- **Faster theme/sidebar preference script** — the pre-paint dark/light and sidebar-collapsed script is now inlined directly in the page instead of loaded as a separate file, removing render-blocking requests on every page load (this theme loaded it twice). Still fully compliant with the site's strict script-loading policy — allow-listed by a cryptographic hash instead of weakening it.
- **Dark/light mode now follows your device's preference** — on a first visit, the theme matches whether your device is set to light or dark mode, instead of always defaulting to dark.

### Fixed

- **`js/disable-highlighters.js` never actually worked** — it tried to delete `main.js`'s `highlighters` object via `typeof highlighters !== 'undefined'`, but that variable was scoped inside `main.js`'s own IIFE and never reachable from another script. The check silently always failed, so this theme was loading and running both `main.js`'s old custom highlighter *and* highlight.js at once. Moot now that the custom highlighter is gone entirely (removed from `main.js` core-side) — deleted the dead file and its `footer_scripts` registration in `functions.php`.

## [1.1.5] — 2026-08-12

### Changed

- **Homepage recent list** — now sorted by `last_modified` instead of publication date, so recently edited articles surface at the top. Falls back to `date` for articles that have never been re-saved. Logic extracted into `docs_get_recently_updated()` in `functions.php` — no core changes required.

### Fixed

- **TOC scroll-spy:** `docs_extract_toc()` now injects `id="toc-{slug}"` on headings that lack one, passing `$renderedContent` by reference so ids are consistent between the article body and the TOC links. Previously, headings without the `[toc]` shortcode had no id at all, making the scroll-spy unable to track them.
  - Duplicate heading titles (e.g. two "Plugins" h3s in the same article) generated the same `id`, causing `getElementById` to always match the first one. Ids are now deduplicated with a `-2`, `-3` suffix so every heading in the DOM has a unique, trackable anchor.
  - Switched from `offsetTop` (relative to nearest positioned parent) to `getBoundingClientRect().top` (relative to viewport) for accurate position tracking regardless of CSS context.
