# Atrium Theme — Changelog

## [1.0.3] — 2026-08-27

### Fixed

## [1.0.2] — 2026-08-24

### Changed

- **Faster theme preference script** — the pre-paint dark/light script is now inlined directly in the page instead of loaded as a separate file, removing one render-blocking request on every page load. Still fully compliant with the site's strict script-loading policy — allow-listed by a cryptographic hash instead of weakening it.
- **Mobile menu accessibility fix** — the off-canvas menu's links are no longer reachable by keyboard or screen reader while it's closed.
