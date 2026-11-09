<?php
/**
 * SynaptikDocs Theme — functions.php
 */

/**
 * Sidebar category order: list category slugs here in the order you want them
 * to appear. Any category not listed falls back after these, alphabetically.
 * Slugs match the keys in data/categories.json.
 */
define('DOCS_CATEGORY_ORDER', [
	'admin-and-settings',
	'appearance',
	'content',
	'tools',
]);

/**
 * Return space-separated CSS body classes.
 */
function theme_body_class(): string
{
	$type    = $_GET['type'] ?? '';
	$slug    = $_GET['slug'] ?? '';
	$classes = ['theme-synaptik-docs'];
	if (empty($type) && empty($slug))      $classes[] = 'is-home';
	elseif (!empty($type) && empty($slug)) $classes[] = 'is-list';
	elseif (!empty($slug))                 $classes[] = 'is-single';
	return implode(' ', $classes);
}

/**
 * Build nav structure: ungrouped items first, then categories (with sub-categories
 * nested under their parent) each holding all their own articles/pages.
 * Sub-categories are read from the "parent" field set in the category manager
 * (Categories → parent category dropdown) — no separate config needed here.
 */
function docs_build_nav_items(): array
{
	$pages      = sl_load_index('page');
	$articles   = sl_load_index('article');
	$categories = sl_load_categories();

	// Ungrouped: pages and articles with show_in_menu and no category
	$ungrouped = [];
	foreach ($pages    as $p) { if (!empty($p['show_in_menu']) && empty($p['category'])) { $p['_type'] = 'page';    $ungrouped[] = $p; } }
	foreach ($articles as $a) { if (!empty($a['show_in_menu']) && empty($a['category'])) { $a['_type'] = 'article'; $ungrouped[] = $a; } }
	usort($ungrouped, function($a, $b) {
		$d = ($a['menu_order'] ?? 99) <=> ($b['menu_order'] ?? 99);
		return $d !== 0 ? $d : strcmp($a['title'] ?? '', $b['title'] ?? '');
	});

	// Collect slugs of every category that has at least one show_in_menu item
	$visibleSlugs = [];
	foreach ($pages    as $p) { if (!empty($p['show_in_menu']) && !empty($p['category'])) $visibleSlugs[sanitizeSlug($p['category'])] = true; }
	foreach ($articles as $a) { if (!empty($a['show_in_menu']) && !empty($a['category'])) $visibleSlugs[sanitizeSlug($a['category'])] = true; }

	// Pull in ancestors of visible categories too, so a sub-category with items
	// still nests under a parent that has none of its own.
	foreach (array_keys($visibleSlugs) as $slug) {
		$current = $categories[$slug]['parent'] ?? '';
		while (!empty($current) && !isset($visibleSlugs[$current])) {
			$visibleSlugs[$current] = true;
			$current = $categories[$current]['parent'] ?? '';
		}
	}

	// Build each visible category's own item list (direct items only, not descendants').
	$groups = [];
	foreach (array_keys($visibleSlugs) as $slug) {
		$items = [];
		foreach ($pages    as $p) { if (!empty($p['category']) && sanitizeSlug($p['category']) === $slug) { $p['_type'] = 'page';    $items[] = $p; } }
		foreach ($articles as $a) { if (!empty($a['category']) && sanitizeSlug($a['category']) === $slug) { $a['_type'] = 'article'; $items[] = $a; } }
		usort($items, function($a, $b) {
			$d = ($a['menu_order'] ?? 99) <=> ($b['menu_order'] ?? 99);
			return $d !== 0 ? $d : strcmp($a['title'] ?? '', $b['title'] ?? '');
		});
		$groups[$slug] = $items;
	}

	// Group children by parent slug, ordered: DOCS_CATEGORY_ORDER entries first
	// (in that order), then any remaining siblings alphabetically by name.
	$order = array_flip(DOCS_CATEGORY_ORDER);
	$sortSiblings = function(array $slugs) use ($order, $categories) {
		usort($slugs, function($a, $b) use ($order, $categories) {
			$posA = $order[$a] ?? PHP_INT_MAX;
			$posB = $order[$b] ?? PHP_INT_MAX;
			if ($posA !== $posB) return $posA <=> $posB;
			return strcasecmp($categories[$a]['name'] ?? $a, $categories[$b]['name'] ?? $b);
		});
		return $slugs;
	};

	$childrenOf = [];
	foreach (array_keys($visibleSlugs) as $slug) {
		$parent = $categories[$slug]['parent'] ?? '';
		$parent = ($parent !== '' && isset($visibleSlugs[$parent])) ? $parent : '';
		$childrenOf[$parent][] = $slug;
	}
	foreach ($childrenOf as $parent => $slugs) {
		$childrenOf[$parent] = $sortSiblings($slugs);
	}

	return [
		'ungrouped'   => $ungrouped,
		'groups'      => $groups,
		'childrenOf'  => $childrenOf,
		'roots'       => $childrenOf[''] ?? [],
		'categories'  => $categories,
	];
}

/**
 * Generate correct URL for a nav item using CMS cleanUrl().
 */
function docs_item_url(array $item): string
{
	$slug    = sl_effective_slug($item);
	$catSlug = !empty($item['category']) ? sanitizeSlug($item['category']) : null;
	return cleanUrl($item['_type'], $slug, null, $catSlug);
}

/**
 * Recursively render one category (and its sub-categories) as a collapsible
 * sidebar group. $depth adds extra indentation for nested levels.
 */
function docs_render_category_group(string $slug, array $nav, string $currentType, string $currentSlug, int $depth = 0): string
{
	$items      = $nav['groups'][$slug] ?? [];
	$children   = $nav['childrenOf'][$slug] ?? [];
	$groupId    = 'sg-' . $slug;
	$groupLabel = $nav['categories'][$slug]['name'] ?? $slug;

	// Groups are open by default server-side; script.js applies any per-group
	// collapsed state the visitor previously saved to localStorage, and always
	// forces the active group's chain open regardless of that saved state.
	$expanded     = 'true';
	$listClasses  = 'sidebar-list';
	$groupClasses = 'sidebar-group' . ($depth > 0 ? ' is-nested' : '');

	$html  = '<div class="' . $groupClasses . '" data-group>';
	$html .= '<button class="sidebar-group-btn" aria-expanded="' . $expanded . '" aria-controls="' . $groupId . '">';
	$html .= '<span class="sidebar-group-icon" aria-hidden="true">' . htmlspecialchars(mb_strtoupper(mb_substr($groupLabel, 0, 2, 'UTF-8'), 'UTF-8')) . '</span>';
	$html .= '<span class="sidebar-group-label">' . htmlspecialchars($groupLabel) . '</span>';
	$html .= '<svg class="sidebar-group-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';
	$html .= '</button>';
	$html .= '<ul class="' . $listClasses . '" id="' . $groupId . '">';
	foreach ($items as $item) {
		$active = ($item['_type'] === $currentType && sl_effective_slug($item) === $currentSlug);
		$html  .= '<li><a href="' . htmlspecialchars(docs_item_url($item)) . '" data-sidebar-link'
		        . ($active ? ' class="active"' : '') . '>'
		        . htmlspecialchars($item['title']) . '</a></li>';
	}
	foreach ($children as $childSlug) {
		$html .= '<li class="sidebar-subgroup">' . docs_render_category_group($childSlug, $nav, $currentType, $currentSlug, $depth + 1) . '</li>';
	}
	$html .= '</ul></div>';

	return $html;
}

/**
 * Render the docs sidebar with collapsible groups and a collapse toggle.
 * Active group detection is done server-side so groups render in their correct
 * open/collapsed state immediately — no JS correction needed on load.
 */
function docs_render_sidebar(array $settings): string
{
	$nav         = docs_build_nav_items();
	$currentType = $_GET['type'] ?? '';
	$currentSlug = $_GET['slug'] ?? '';

	$html = '<aside class="docs-sidebar" id="docs-sidebar" aria-label="Documentation navigation">';
	$html .= '<div class="sidebar-scroll">';

	if (!empty($nav['ungrouped'])) {
		$html .= '<ul class="sidebar-list sidebar-ungrouped">';
		foreach ($nav['ungrouped'] as $item) {
			$active = ($item['_type'] === $currentType && sl_effective_slug($item) === $currentSlug);
			$html  .= '<li><a href="' . htmlspecialchars(docs_item_url($item)) . '" data-sidebar-link'
			        . ($active ? ' class="active"' : '') . '>'
			        . htmlspecialchars($item['title']) . '</a></li>';
		}
		$html .= '</ul>';
	}

	foreach ($nav['roots'] as $rootSlug) {
		$html .= docs_render_category_group($rootSlug, $nav, $currentType, $currentSlug);
	}

	$html .= '</div>';

	// Collapse toggle button at bottom of sidebar
	$html .= '<button class="sidebar-collapse-btn" id="sidebar-collapse-btn" aria-label="Collapse sidebar" title="Collapse sidebar">';
	$html .= '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>';
	$html .= '</button>';

	$html .= '</aside>';
	return $html;
}

/**
 * Extract h2/h3/h4 headings from rendered HTML for the right-hand TOC.
 * Injects id="toc-{slug}" on any heading that lacks one, so the TOC
 * scroll-spy always has a matching DOM element to track — regardless of
 * whether the [toc] shortcode is present in the article.
 * Returns the mutated HTML by reference so ids are consistent between
 * the article body and the TOC links.
 */
function docs_extract_toc(string &$html): array
{
	$toc    = [];
	$idSeen = [];
	$html   = preg_replace_callback(
		'/<(h[234])([^>]*)>(.*?)<\/h[234]>/is',
		function ($m) use (&$toc, &$idSeen) {
			$tag   = $m[1];
			$attrs = $m[2];
			$inner = $m[3];
			$text  = html_entity_decode(strip_tags($inner), ENT_QUOTES | ENT_HTML5, 'UTF-8');
			if (preg_match('/\bid="([^"]+)"/i', $attrs, $idm)) {
				$id    = $idm[1];
				$attrs = preg_replace('/\s*\bid="[^"]+"/i', '', $attrs);
			} else {
				$id = 'toc-' . sanitizeSlug($text);
			}
			// Deduplicate: suffix with -2, -3 ... if id already seen
			$base = $id;
			$n    = 1;
			while (isset($idSeen[$id])) { $id = $base . '-' . (++$n); }
			$idSeen[$id] = true;
			$attrs = ' id="' . htmlspecialchars($id) . '"' . $attrs;
			$toc[] = ['level' => (int)substr($tag, 1), 'id' => $id, 'text' => $text];
			return "<{$tag}{$attrs}>{$inner}</{$tag}>";
		},
		$html
	);
	return $toc;
}

/**
 * Render the in-page TOC HTML.
 */
function docs_render_toc(array $toc): string
{
	if (empty($toc)) return '';
	// Prefix anchors with the current page path to work around <base href> resolving
	// bare #anchors against the base URL instead of the current page URL.
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
	$currentUrl = rtrim($scheme . '://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?'), '/') . '/';
	$html  = '<nav class="docs-toc" aria-label="On this page">';
	$html .= '<div class="toc-title">On this page</div><ul class="toc-list">';
	foreach ($toc as $item) {
		$cls = match($item['level']) {
			3 => ' class="toc-h3"',
			4 => ' class="toc-h4"',
			default => ''
		};
		$html .= '<li' . $cls . '><a href="' . htmlspecialchars($currentUrl) . '#' . htmlspecialchars($item['id']) . '">' . htmlspecialchars($item['text']) . '</a></li>';
	}
	$html .= '</ul></nav>';
	return $html;
}

/**
 * Load articles sorted by last_modified date descending.
 * Falls back to publication date if last_modified is absent.
 */
function docs_get_recently_updated(int $limit = 6): array
{
	$items = sl_load_all_items('article');
	usort($items, function($a, $b) {
		$aDate = !empty($a['last_modified']) ? $a['last_modified'] : ($a['date'] ?? '');
		$bDate = !empty($b['last_modified']) ? $b['last_modified'] : ($b['date'] ?? '');
		return strcmp($bDate, $aDate);
	});
	return array_slice($items, 0, $limit);
}
/**
 * Renders the site-wide doc-status badge for the homepage hero, sourced
 * from docs-status.php. Value is one of 'up_to_date', 'needs_updating',
 * or 'YYYY-MM-DD'. Returns '' if unset.
 */
function docs_render_status_badge(): string
{
	static $value = null;
	if ($value === null) {
		$value = trim((string)(@include __DIR__ . '/docs-status.php'));
	}
	if ($value === '') return '';

	if ($value === 'up_to_date') {
		return '<span class="docs-status-badge docs-status-ok">Doc Status: Up to date</span>';
	}
	if ($value === 'needs_updating') {
		return '<span class="docs-status-badge docs-status-stale">Doc Status: Needs updating</span>';
	}
	$date = DateTime::createFromFormat('Y-m-d', $value);
	if ($date) {
		return '<span class="docs-status-badge docs-status-ok">Doc Status: Updated ' . htmlspecialchars($date->format('M j, Y')) . '</span>';
	}
	return '';
}

function docs_get_prev_next(string $currentType, string $currentSlug): array
{
	$nav  = docs_build_nav_items();
	$flat = $nav['ungrouped'];
	foreach ($nav['groups'] as $items) { foreach ($items as $i) $flat[] = $i; }

	$idx = null;
	foreach ($flat as $i => $item) {
		if ($item['_type'] === $currentType && sl_effective_slug($item) === $currentSlug) {
			$idx = $i; break;
		}
	}
	return [
		'prev' => ($idx !== null && $idx > 0)                ? $flat[$idx - 1] : null,
		'next' => ($idx !== null && $idx < count($flat) - 1) ? $flat[$idx + 1] : null,
	];
}
