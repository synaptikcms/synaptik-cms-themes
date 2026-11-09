# Prism Theme — Changelog

## [1.0.4] — 2026-08-27

- **Pagination fade transition merged into this theme's own script** — previously loaded from a separate core file (`assets/js/page-transitions.js`) on every theme regardless of whether it used it; now part of this theme's own `js/main.js`, same effect, one less request.

# 

- **Renamed content types not reflected on the homepage/footer** — "Explore Articles", "View Projects", "Latest Articles", "Featured Projects", and "View All Projects" always showed the default English word even if you renamed a content type in Settings → Reading. Now follows your custom name.

## [1.0.3] — 2026-08-24

### Changed

- **Faster theme preference script** — the pre-paint dark/light script is now inlined directly in the page instead of loaded as a separate file, removing one render-blocking request on every page load. Still fully compliant with the site's strict script-loading policy — allow-listed by a cryptographic hash instead of weakening it. The tag-link click handler moved into the theme's own `main.js`, and the async-stylesheet `onload=` handler now uses the shared class-based `css-async.js`.
- **Dark/light mode now follows your device's preference** — on a first visit, the theme matches whether your device is set to light or dark mode, instead of always defaulting to light.
- **Mobile menu accessibility fix** — the off-canvas menu's links are no longer reachable by keyboard or screen reader while it's closed.
