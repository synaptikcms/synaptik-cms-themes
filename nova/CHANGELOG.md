# Nova Theme — Changelog

## [1.1.5] — 2026-08-27

- **Fade-in and pagination fade transition merged into this theme's own script** — previously loaded from a separate core file (`assets/js/page-transitions.js`) on every theme regardless of whether it used it; now part of this theme's own `js/interactions.js`, same effect, one less request.
- **Renamed content types not reflected on the homepage/footer** — "Explore Articles", "View Projects", "Latest Articles", "Featured Projects", and "View All Projects" always showed the default English word even if you renamed a content type in Settings → Reading. Now follows your custom name.
