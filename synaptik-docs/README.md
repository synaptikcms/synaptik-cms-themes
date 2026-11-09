# Synaptik-Docs Theme — User Guide

**Synaptik-Docs** is a clean, documentation-focused theme for Synaptik CMS: a collapsible sidebar with grouped/nested categories, an in-page table of contents, light/dark mode, and an inline search dropdown. Built for structured technical content — user guides, API references, changelogs.

---

## Installation

1. Go to **Admin → Appearance → Import Theme**
2. Upload `synaptik-docs.zip`
3. Click **Activate**

Or manually: copy the `synaptik-docs/` folder into `theme/` and activate from the theme manager.

---

## How content becomes navigation

The sidebar and top nav are built automatically from your **pages** and **articles** — there's no separate menu to maintain for docs content:

- Any page/article with **"Show in menu"** enabled appears in the navigation.
- Items with **no category** appear ungrouped, at the top of the sidebar.
- Items with a **category** are grouped under a collapsible section named after that category.
- **Sub-categories**: set a category's **parent** (Admin → Categories → parent category dropdown) to nest it under another category in the sidebar. No extra config needed — the theme reads the parent relationship directly.
- Within a group, items are ordered by **menu order**, then alphabetically by title.

### Category display order

By default, categories are sorted alphabetically. To force a specific order, edit `DOCS_CATEGORY_ORDER` at the top of `functions.php`:

```php
define('DOCS_CATEGORY_ORDER', [
    'admin-and-settings',
    'appearance',
    'content',
    'tools',
]);
```

List category **slugs** (not display names), in the order you want them to appear. Any category not listed falls back after these, alphabetically. This only controls order — it doesn't hide or restrict anything.

---

## Page templates

Two optional templates are available from the **Template** dropdown when editing a page:

### Contact
**Admin → Content → Pages → Add** → Template: `Contact`

Renders your page content followed by the site's contact form (same form used by the `[contact_form]` shortcode elsewhere — requires the Contact/Form Builder plugin to be active and an email configured in **Admin → Settings → Contact**).

### Landing
**Admin → Content → Pages → Add** → Template: `Landing`

A wide layout without the sidebar/TOC — useful for a marketing-style page inside the docs site. Supports the page's featured image as a full-width hero (toggle "Show featured image") and lets you hide the title (toggle "Show title") if your content already has one.

Pages without a template selected use the standard docs layout: sidebar, breadcrumbs, article body, and right-hand table of contents.

---

## Table of contents (TOC)

The right-hand "On this page" panel is generated automatically from your `<h2>`, `<h3>`, and `<h4>` headings — no shortcode or setup required. Headings get a stable, deduplicated anchor id automatically (`toc-your-heading-text`, with `-2`, `-3` suffixes for repeated titles), and the panel scroll-spies the active section as you scroll.

---

## Search

A search box sits in the top bar (⌘K shortcut) and searches across pages and articles as you type. No configuration needed — it's powered by core's search index.

---

## Dark / light mode

A toggle button (sun/moon icon) sits in the top bar. On a first visit, the theme matches the visitor's OS/browser preference; after that, their explicit choice is remembered in the browser and restored on later visits — no flash of the wrong theme on load.

---

## Light/dark logo variants

The site logo (top bar) can swap automatically with the dark/light mode toggle — no extra setup in this theme, it's handled by core's `render_site_logo()`.

1. Set your logo as usual in **Admin → Settings → Site logo** (e.g. uploads as `files/logo.webp`).
2. Via **Admin → File Manager**, add two more files next to it, named with `-light` / `-dark` suffixes before the extension:
   - `files/logo-dark.webp` — shown in dark mode
   - `files/logo-light.webp` — shown in light mode
3. Reload the site. Both are detected automatically; the switch is pure CSS (no flash, no extra JS).

If only one (or neither) of the two variants exists, the theme silently falls back to the single logo configured in Settings — nothing breaks.

---

## Homepage status badge

The homepage hero shows a small status badge (e.g. **"Status: Up to date"**) in place of the default "Documentation" badge. It's controlled by a single file — no admin UI, no custom fields (the homepage isn't a content item, so nothing can be attached to it there).

Edit `docs-status.php` and set the return value:

```php
return 'up_to_date';       // green badge: "Status: Up to date"
return 'needs_updating';   // orange badge: "Status: Needs updating"
return '2026-08-25';       // badge: "Status: Updated Aug 25, 2026"
return '';                 // no badge — falls back to the default "Documentation" badge
```

Save the file and reload the homepage — no cache to clear.

---

## Recent doc updates (homepage)

The homepage also lists recently updated articles, sorted by **last modified date** (falls back to publish date for articles never re-saved since publishing). This is automatic — no setup needed, controlled by `Settings → Reading → Articles per page` for how many show.

---

## Local fonts

The theme self-hosts its fonts (Inter for body text, JetBrains Mono for code) from `css/fonts/` instead of loading them from an external font CDN — no extra network requests, no third-party origin to preconnect to. If you replace these files, keep the same filenames or update the `@font-face` `src` paths and the `<link rel="preload">` in `header.php` together.

---

## Customising colours

Open **Admin → Template Editor**, select `css/style.css`. The colour tokens are near the top of the file, in `:root` (dark, default) and `[data-theme="light"]` (light mode):

```css
--accent:        #4e9c59;   /* primary accent — green */
--accent-dark:   #3a8a46;
--accent-light:  #60c06e;
--bg:            #1a1a21;   /* main background (dark) */
--text:          #e4e4ec;   /* primary text (dark) */
```

Changing `--accent` recolours links, buttons, active sidebar items, and badges.

---

## Troubleshooting

**A page doesn't show up in the sidebar**
Check "Show in menu" is enabled on that page/article in the editor.

**A category isn't nested where I expect**
Check its **parent** category in Admin → Categories. Only categories with at least one visible item (or a descendant that has one) appear in the sidebar; the theme walks up the parent chain automatically to keep the hierarchy connected.

**TOC is empty or missing entries**
The TOC only picks up `<h2>`–`<h4>` headings in the rendered content — check your headings aren't styled as bold paragraph text instead of real heading tags.

**Homepage status badge doesn't change**
Make sure you edited `docs-status.php` (not a custom field or a page) — see "Homepage status badge" above. This file is theme code, so changes need to be re-uploaded to your server if you're editing a local copy.

**Contact template shows no form**
Confirm the Contact/Form Builder plugin is active and a recipient email is set in Admin → Settings → Contact.

---

## Changelog

See `CHANGELOG.md`.
