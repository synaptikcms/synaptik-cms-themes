# Myelin Theme — Changelog

## [1.0.3] — 2026-08-27

- **Renamed content types not reflected on the homepage/footer** — "Explore Articles", "View Projects", "Latest Articles", "Featured Projects", and "View All Projects" always showed the default English word even if you renamed a content type in Settings → Reading. Now follows your custom name.

## [1.0.2] — 2026-08-24

- **Front-end security policy compliance** — the async-stylesheet `onload=` handler now uses the shared class-based `css-async.js` instead of inline JS. Theme keeps working under the site's stricter script-loading policy (`script-src` no longer needs `'unsafe-inline'`). No visible change.
