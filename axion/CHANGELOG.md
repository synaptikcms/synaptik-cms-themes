# Axion Theme — Changelog

## [1.0.3] — 2026-08-27

- **Renamed content types not reflected on the homepage/footer** — "Explore Articles", "View Projects", "Latest Articles", "Featured Projects", and "View All Projects" always showed the default English word even if you renamed a content type in Settings → Reading. Now follows your custom name.
- **Pagination fade transition merged into this theme's own script** — previously loaded from a separate core file (`assets/js/page-transitions.js`) on every theme regardless of whether it used it; now part of this theme's own `script.js`, same effect, one less request.

## [1.0.2] — 2026-08-24

# 

- **Front-end security policy compliance** — the async-stylesheet `onload=` handler now uses the shared class-based `css-async.js` instead of inline JS. Theme keeps working under the site's stricter script-loading policy (`script-src` no longer needs `'unsafe-inline'`). No visible change.
