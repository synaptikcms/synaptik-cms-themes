# Ink Theme — Changelog

## [1.0.3] — 2026-08-27

- **Search results showed the raw content type instead of your renamed one** — the built-in search modal's result badges ("article", "project"...) ignored a custom name set in Settings → Reading. Now shows your renamed label.

## [1.0.2] — 2026-08-24

- **Faster theme/sidebar preference script** — the pre-paint dark/light script is now inlined directly in the page instead of loaded as a separate file, removing one render-blocking request on every page load. Still fully compliant with the site's strict script-loading policy — allow-listed by a cryptographic hash instead of weakening it. Also removed a redundant `window.CMS_BASE_URL=` assignment — the shared `front-boot.js` already sets it.
- **Dark/light mode now follows your device's preference** — on a first visit, the theme matches whether your device is set to light or dark mode, instead of always defaulting to dark.
- **Mobile menu accessibility fix** — the search field and navigation links inside the mobile menu are no longer reachable by keyboard or screen reader while it's closed.
