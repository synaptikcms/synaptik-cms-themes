# Vitae Theme — User Guide

**Vitae** is a dark creative CV/portfolio theme for Synaptik CMS. Designed for designers, developers, photographers, and anyone who wants a personal site that doubles as a professional portfolio — with an identity card on the home page, animated skill bars, an experience timeline, a project gallery, and a contact form.

---

## Installation

1. Go to **Admin → Appearance → Import Theme**
2. Upload `vitae.zip`
3. Click **Activate**

Or manually: copy the `vitae/` folder into `theme/` and activate from the theme manager.

---

## Quick overview — how it all fits together

Vitae has **two kinds of content**:

- **Regular content** (projects, articles, pages) — you create these the normal way in the admin.
- **CV data** (bio, skills, timeline) — you enter these in a special page called `home-data`. The home page reads that page automatically and displays everything.

So the workflow is: create the `home-data` page once, fill in a few fields, and the home page builds itself.

---

## Step 1 — Site identity (2 minutes)

Go to **Admin → Settings → General**.

**Site title** → Your name.
Used for the large heading on the home page and as initials in the sidebar avatar if you haven't set a logo.
Example: `Jane Smith`

**Site description** → A clean one-liner about yourself, written for Google.
This is what appears in search results and social sharing previews. Write it as a proper sentence, not a list of roles.
Example: `Freelance designer and developer based in Paris, building digital products for startups.`

**Site logo** → Your profile photo.
This image appears as the circular profile photo in the identity card on the home page. Use a square image, at least 300×300px. If you don't set one, Vitae shows your initials on a gradient background instead.

---

## Step 2 — Social links

Go to **Admin → Settings → Social**.

Enable social links and add your profiles. They appear in the identity card on the home page and in the footer.

---

## Step 3 — Create the home-data page (the important one)

This is where all your CV content lives — your bio, your skills, and your experience timeline.

**Admin → Content → Pages → Add new page**

Set the title to exactly: `home-data`

That's the only thing that matters for this page. The slug will automatically become `home-data`, and the home page will find it by that slug.

> You do not need to add this page to your menu. You do not need to publish it. It just needs to exist.

---

## Step 4 — Set up the custom fields (once)

Before you can fill in your CV data, you need to tell Synaptik CMS what fields to create. You only do this once.

Go to **Admin → Settings → Custom Fields → Pages**.

Add these five fields, one at a time, using the **+ Add a field** button:

| Label | Key (type this exactly) | Type |
|---|---|---|
| Roles | `roles` | Short text |
| Bio | `bio` | Long text |
| Stats | `stats` | Short text |
| Skills | `skills` | Long text |
| Timeline | `timeline` | Long text |

Save.

---

## Step 5 — Fill in your CV data

Go back to your `home-data` page and open it for editing. In the editor sidebar, click the **Custom Fields** tab. You'll see the three fields you just created.

### Roles field

This is the animated typewriter text that cycles under your name in the identity card on the left. It is **completely separate from your site description** — your site description stays clean for Google, and this field handles the animation.

Format: write your roles separated by a pipe `|`.

Example:

```
UX Designer | Frontend Developer | Photographer
```

This cycles through all three phrases one by one. If you only have one role, just write it without a pipe — it displays as static text.

If you leave this field empty, the typewriter falls back to your site description. Fill it to avoid that.

---

### Bio field

This is the longer personal text that appears in the right panel on the home page. It's different from the `roles` field — roles feeds the typewriter animation, bio is a full paragraph about yourself shown in the intro panel.

Example:

```
I'm a freelance developer and designer based in San Diego with 10 years of experience
building digital products for startups and creative studios. I specialise in
front-end architecture, design systems, and making complex things feel simple.
```

If you leave this empty, the home page falls back to your site description.

---

### Stats field

Three or four key numbers displayed under your bio in the intro panel. Pipe-separated, each stat is a value followed by a label on the same word.

Format: `value label | value label | value label`

Example:

```
10+ Years | 50+ Projects | 20 Clients
```

The number before the first space is the large value, everything after is the small label below it. Leave this empty if you don't want stat counters.

---

### Skills field

One skill per line. Each line has three parts separated by `|`:

```
Skill name | level | Category
```

- **Skill name** — whatever you want to display
- **level** — a number from 0 to 100 (this sets the width of the progress bar)
- **Category** — a group label. Skills with the same category are shown together.

Example:

```
PHP | 92 | Backend
MySQL | 85 | Backend
Node.js | 72 | Backend
JavaScript | 90 | Frontend
React | 78 | Frontend
CSS | 95 | Frontend
Figma | 85 | Design
Illustrator | 70 | Design
Git | 88 | Tools
Docker | 65 | Tools
```

This produces four groups of animated bars: Backend, Frontend, Design, Tools.

**Notes:**
- Category is optional. If you omit it (`PHP | 92`), the skill goes into a default group.
- Lines starting with `#` are skipped — use them as comments: `# Not publishing these yet`
- Blank lines are ignored.

---

### Timeline field

One entry per block. Use `##` to start a new section (Experience, Education, etc.).

Each entry is one line in this format:

```
Job title | Company | Period
```

Add an optional description on the line immediately below. Then leave a blank line before the next entry.

Add `| current` at the end of the first line if it's your current position — this puts a coloured dot on that entry.

Full example:

```
## Experience

Lead Developer | Studio Neon | 2023 — Present | current
Architected and shipped three SaaS products from concept to launch.

Frontend Developer | Freelance | 2020 — 2023
Built 20+ websites and web apps for clients across North America.

Junior Developer | WebAgency | 2018 — 2020
Maintenance and feature development on e-commerce platforms.

## Education

BSc Computer Science | University of California | 2015 — 2018
Graduated with first-class honours.

Web Development Degree | California High | 2015
```

**Notes:**
- `## Experience` and `## Education` are section headers — use any names you want.
- `| current` is optional — only use it for your current role.
- The description line is optional. Leave a blank line between entries.
- Entries appear in the order you write them — put the most recent first.

---

## Step 6 — Navigation

Go to **Admin → Edit Menu**.

A typical CV menu structure:

```
Home
Experience    ← link to your timeline page (see below)
Skills        ← link to your skills page (see below)
Projects
Blog
Contact
```

---

## Step 7 — Footer

Go to **Admin → Settings → Footer**.

Set your copyright line. Use `{year}` as a placeholder for the current year.
Example: `© {year} Jane Smith. All rights reserved.`

---

## What the home page shows automatically

Once you've completed the steps above, the home page builds itself:

- **Identity card (left)** — your profile photo or initials, your name, the animated typewriter role, the availability badge, your social links, and CTA buttons.
- **Intro panel (right)** — your name in large text, your bio (from the `bio` field), and CTA buttons.
- **Skills section** — your animated skill bars, if the `skills` field is filled.
- **Timeline section** — your experience/education timeline, if the `timeline` field is filled.
- **Projects section** — your most recent projects, if Settings → Homepage → Show projects is enabled.
- **Articles section** — your most recent articles, if Settings → Homepage → Show articles is enabled.

**The "Get in touch" button** appears automatically if you have a page whose slug contains the word `contact`.

**The scroll indicator** at the bottom of the hero scrolls to the first section below it.

---

## Optional: dedicated Skills and Experience pages

Vitae includes two page templates for standalone Skills and Experience pages in your menu.

### Skills page

1. **Admin → Content → Pages → Add**
2. Title: `Skills` (or anything)
3. Template dropdown: `CV — Skills`
4. Fill the `skills` custom field — same format as above
5. Publish and add to your menu

### Experience / Timeline page

1. **Admin → Content → Pages → Add**
2. Title: `Experience` (or anything)
3. Template dropdown: `CV — Timeline`
4. Fill the `timeline` custom field — same format as above
5. Publish and add to your menu

---

## Contact page

No custom fields needed.

1. **Admin → Content → Pages → Add**
2. Title: `Contact`
3. Template dropdown: `CV — Contact`
4. Write an intro paragraph in the main editor (optional)
5. Publish

The styled contact form appears automatically. To set the recipient email: **Admin → Settings → Contact → Contact email**.

---

## Dark / light mode

A toggle button (moon/sun icon) sits at the bottom of the sidebar. Clicking it switches between dark and light mode instantly. The preference is saved in the browser and restored on the next visit — no flash on load.

The default theme is dark. If you want light as default, there is nothing to change in the code — the browser preference is what drives it.

---

## Theme options (theme.json)

The `vitae_options` block in `theme.json` lets you configure several behaviours without touching any PHP or CSS. Open `theme.json` in **Admin → Template Editor** to edit these values.

```json
"vitae_options": {
    "cv_page_slugs":         ["home-data", "homedata", "about", "a-propos", "apropos"],
    "show_availability":     true,
    "show_scroll_hint":      true,
    "schema_type":           "Person",
    "availability_i18n_key": "vitae_available"
}
```

### `cv_page_slugs`
The list of page slugs the home page searches to find your CV data. The first matching page wins. If you named your data page something other than `home-data`, add its slug here.

Example — if your page slug is `cv`:
```json
"cv_page_slugs": ["cv", "home-data", "about"]
```

### `show_availability`
Controls whether the "Available for work" badge appears on the identity card.
- `true` → badge shown (default)
- `false` → badge hidden — use when you are not available for new work

### `show_scroll_hint`
Controls whether the animated scroll indicator appears at the bottom of the hero.
- `true` → shown (default)
- `false` → hidden

### `availability_i18n_key`
The i18n key used for the badge text. Defaults to `vitae_available` ("Available for work"). To use custom text, add a key to `lang/en.json` and reference it here.

Example — add to `lang/en.json`:
```json
"vitae_open_to_offers": "Open to offers"
```
Then in `theme.json`:
```json
"availability_i18n_key": "vitae_open_to_offers"
```

### `schema_type`
Controls the JSON-LD structured data block injected in the `<head>` of the home page. When set to `"Person"`, Vitae outputs a `schema.org/Person` block containing your name, site URL, description, and social profile URLs. This helps Google understand the site as a personal portfolio and can contribute to rich results or a Knowledge Panel for your name.

To disable the JSON-LD block entirely, set this to any value other than `"Person"` (e.g. `"none"`).

The social URLs in `sameAs` are pulled automatically from your social links in **Admin → Settings → Social**.

---

## Customising colours

Open **Admin → Template Editor**, select `css/style.css`. The colour tokens are at the very top:

```css
:root {
    --vt-bg:      #09090b;   /* main background */
    --vt-bg2:     #101013;   /* sidebar and alternate section background */
    --vt-surface: #18181c;   /* cards and input fields */
    --vt-text:    #e4e4e9;   /* primary text */
    --vt-muted:   #6b6b7e;   /* secondary text, dates, labels */
    --vt-acc:     #8b5cf6;   /* primary accent — violet */
    --vt-acc2:    #ec4899;   /* secondary accent — pink */
    --vt-green:   #22c55e;   /* availability badge */
}
```

Changing `--vt-acc` and `--vt-acc2` recolours skill bars, buttons, links, chips, and the scroll indicator all at once.

---

## Troubleshooting

**Skills or timeline don't appear on the home page**
Make sure your page slug is `home-data` (check Admin → Pages). Also verify the custom field keys are exactly `skills` and `timeline` in Settings → Custom Fields → Pages.

**Skill bars appear but are empty (0%)**
Each line needs two `|` characters: `PHP | 90 | Backend`. If the level value is missing or non-numeric, the bar shows at 0%.

**Timeline shows nothing**
Make sure each entry line has at least one `|`. A line with no `|` is treated as a description, not an entry.

**Typewriter shows one static role**
You need a `|` between roles in the `roles` custom field on your `home-data` page: `Designer | Developer` — not a comma or slash.

**"Get in touch" button doesn't appear**
Create a page whose title or slug contains the word `contact` and publish it.

**Projects or articles don't appear on the home page**
Admin → Settings → Homepage — enable the relevant section. Also check that individual items have "Show on homepage" ticked.

**Contact form isn't styled**
Make sure `css/contact.css` exists in the theme folder.

---

## Changelog

### 1.0.0
Initial release.
- Added `roles` custom field for typewriter animation, separate from site description (SEO fix)
- Added dark/light mode toggle in the sidebar, preference saved in browser
- Sidebar redesigned: name + sub-label next to the logo mark, accent bar on active links, gradient wash, social icons moved here
- Project cards now use CSS columns masonry layout with alternating aspect ratios
- Shortcodes `[recent_articles]` and `[recent_projects]` fully styled to match the theme (grid cards, hover zoom, tags, chip links)
- Light mode tokens added across all components including callout shortcodes
