# Blueish Theme — Changelog

## [1.3.4] — 2026-08-26

### Changed

- **Fade-in effect merged into this theme's own script** — previously loaded from a separate core file (`assets/js/page-transitions.js`) on every theme regardless of whether it used it; now part of this theme's own `script.js`, same effect, one less request.
