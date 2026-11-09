# Vitae Theme — Changelog

## [1.0.2] — 2026-08-26

### Fixed

- **Renamed project type not reflected on the homepage** — the "View All Projects" link always showed the default English word even if you renamed the Project content type in Settings → Reading. Now follows your custom name.

## [1.0.1] — 2026-08-24

### Changed

- **Faster theme/sidebar preference script** — the pre-paint dark/light script is now inlined directly in the page instead of loaded as a separate file, removing one render-blocking request on every page load. Still fully compliant with the site's strict script-loading policy — allow-listed by a cryptographic hash instead of weakening it.
- **Dark/light mode now follows your device's preference** — on a first visit, the theme matches whether your device is set to light or dark mode, instead of always defaulting to dark.
