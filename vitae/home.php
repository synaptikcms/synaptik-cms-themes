<?php
/*
 * home.php — Vitae Theme
 *
 * CV data (bio, skills, timeline) is read from a page whose slug contains
 * "home-data", "homedata", "about", or "a-propos" — whichever is found first.
 * Create that page in Admin → Pages, fill its custom fields, and this template
 * picks them up automatically. The page does not need to be in the menu.
 *
 * Custom fields to add in Settings → Custom Fields → Pages:
 *
 *   roles     Short text  Typewriter animation text. Pipe-separated: Designer | Developer | Photographer
 *             If empty, falls back to site description (not ideal for SEO — fill this field).
 *
 *   bio       Long text   Longer personal description shown in the right panel.
 *             If empty, falls back to site description.
 *
 *   stats     Short text  Key numbers shown under the bio. Pipe-separated: "10+ Years | 50+ Projects | 20 Clients"
 *             Each stat is split on the first space: value + label.
 *
 *   skills    Long text   One skill per line: Name | level | Category
 *             e.g.  PHP | 92 | Backend
 *
 *   timeline  Long text   See page-templates/timeline.php for format.
 */

// ── Content data ─────────────────────────────────────────────────────────────
$allProjects = sl_load_index('project');
usort($allProjects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
$recentProjects = array_slice(
    array_values(array_filter($allProjects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'])),
    0, (int)($settings['projects_per_page'] ?? 6)
);

$allArticles = sl_load_index('article');
usort($allArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
$recentArticles = array_slice(
    array_values(array_filter($allArticles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'])),
    0, (int)($settings['articles_per_page'] ?? 4)
);

$contactLink = '';
foreach (sl_load_index('page') as $p) {
    if (stripos($p['slug'] ?? '', 'contact') !== false || stripos($p['title'] ?? '', 'contact') !== false) {
        $contactLink = cleanUrl('page', sl_effective_slug($p));
        break;
    }
}

// ── Load CV data from the "home data" page ────────────────────────────────────
// cv_page_slugs from theme.json → vitae_options, with fallback
$cvDataSlugs = vitae_option('cv_page_slugs', ['home-data', 'homedata', 'about', 'a-propos', 'apropos']);
$cvPage      = null;
$allPages    = sl_load_index('page');
foreach ($allPages as $p) {
    $slug = strtolower($p['slug'] ?? '');
    foreach ($cvDataSlugs as $candidate) {
        if (strpos($slug, $candidate) !== false) {
            $cvPage = sl_load_item('page', $p['_file'] ?? $slug);
            break 2;
        }
    }
}

$cf          = $cvPage['custom_fields'] ?? [];
$bio         = trim($cf['bio'] ?? '');
$roles       = trim($cf['roles'] ?? '');  // Typewriter text — separate from site description (SEO)
$rawStats    = trim($cf['stats'] ?? '');  // e.g. "10+ ans | 50+ projets | 20 clients"
$rawSkills   = trim($cf['skills'] ?? '');
$rawTimeline = trim($cf['timeline'] ?? '');

// Parse stats — pipe-separated: "value Label | value Label"
$stats = [];
if ($rawStats !== '') {
    foreach (explode('|', $rawStats) as $s) {
        $s = trim($s);
        if ($s === '') continue;
        // Split on first space: "10+ ans" → value="10+" label="ans"
        $spacePos = strpos($s, ' ');
        if ($spacePos !== false) {
            $stats[] = ['value' => substr($s, 0, $spacePos), 'label' => substr($s, $spacePos + 1)];
        } else {
            $stats[] = ['value' => $s, 'label' => ''];
        }
    }
}

// ── Parse skills ──────────────────────────────────────────────────────────────
$skills    = [];
$skillCats = [];
if ($rawSkills !== '') {
    foreach (explode("\n", $rawSkills) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 2) continue;
        $cat = isset($parts[2]) && $parts[2] !== '' ? $parts[2] : 'Skills';
        if (!in_array($cat, $skillCats, true)) $skillCats[] = $cat;
        $skills[] = ['name' => $parts[0], 'level' => max(0, min(100, (int)$parts[1])), 'cat' => $cat];
    }
}
$skillsGrouped = [];
foreach ($skills as $s) { $skillsGrouped[$s['cat']][] = $s; }

// ── Parse timeline ────────────────────────────────────────────────────────────
$tlEntries = [];
$tlCats    = [];
$curCat    = 'Experience';
if ($rawTimeline !== '') {
    $lines = explode("\n", $rawTimeline);
    $i     = 0;
    while ($i < count($lines)) {
        $line = trim($lines[$i]);
        if (strpos($line, '##') === 0) {
            $curCat = trim(substr($line, 2));
            if (!in_array($curCat, $tlCats, true)) $tlCats[] = $curCat;
            $i++; continue;
        }
        if ($line === '') { $i++; continue; }
        $parts     = array_map('trim', explode('|', $line));
        $isCurrent = strtolower(end($parts)) === 'current';
        if ($isCurrent) array_pop($parts);
        $desc = '';
        if (isset($lines[$i + 1]) && trim($lines[$i + 1]) !== '' && strpos(trim($lines[$i + 1]), '##') !== 0 && strpos(trim($lines[$i + 1]), '|') === false) {
            $desc = trim($lines[$i + 1]);
            $i++;
        }
        if (!in_array($curCat, $tlCats, true)) $tlCats[] = $curCat;
        $tlEntries[] = [
            'title'   => $parts[0] ?? '',
            'org'     => $parts[1] ?? '',
            'period'  => $parts[2] ?? '',
            'desc'    => $desc,
            'cat'     => $curCat,
            'current' => $isCurrent,
        ];
        $i++;
    }
}
$tlGrouped = [];
foreach ($tlEntries as $e) { $tlGrouped[$e['cat']][] = $e; }

$showSkills   = !empty($skills);
$showTimeline = !empty($tlEntries);

// Determine the first section below the hero so the scroll button targets it
$firstSectionId = 'skills';
if ($showSkills)                                                            $firstSectionId = 'skills';
elseif ($showTimeline)                                                      $firstSectionId = 'experience';
elseif (!empty($recentProjects) && !empty($settings['show_projects_on_homepage'])) $firstSectionId = 'projects';
elseif (!empty($recentArticles) && !empty($settings['show_articles_on_homepage'])) $firstSectionId = 'articles';
?>

<div class="vt-home">

<!-- ══ HERO ═══════════════════════════════════════════════════════════════ -->
<section class="vt-home-hero">
    <div class="vt-home-hero-bg" aria-hidden="true">
        <div class="vt-hero-blob vt-hero-blob--a"></div>
        <div class="vt-hero-blob vt-hero-blob--b"></div>
        <div class="vt-hero-dots"></div>
    </div>

    <div class="vt-home-hero-inner">

        <!-- Left: identity card -->
        <div class="vt-identity vt-reveal">
            <div class="vt-identity-avatar">
                <?php
                $logo = render_site_logo($settings, 'vt-identity-photo');
                if ($logo) {
                    echo $logo;
                } else {
                    $initials = '';
                    foreach (array_slice(explode(' ', $settings['site_title'] ?? 'S'), 0, 2) as $w) {
                        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
                    }
                    echo '<div class="vt-identity-initials">' . htmlspecialchars($initials) . '</div>';
                }
                ?>
            </div>
            <div class="vt-identity-name"><?php echo htmlspecialchars($settings['site_title'] ?? ''); ?></div>
            <div class="vt-identity-role">
                <span class="vt-tw" data-words="<?php echo htmlspecialchars($roles !== '' ? $roles : ($settings['site_description'] ?? '')); ?>"></span><span class="vt-cursor" aria-hidden="true">|</span>
            </div>
            <?php if (vitae_option('show_availability', true)): ?>
            <div class="vt-identity-status">
                <span class="vt-status-dot" aria-hidden="true"></span>
                <?php echo __t(vitae_option('availability_i18n_key', 'vitae_available')); ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
            <div class="vt-identity-social">
                <?php foreach ($settings['footer_social_links'] as $s): ?>
                    <?php if (!empty($s['platform']) && !empty($s['url'])): ?>
                    <a href="<?php echo htmlspecialchars($s['url']); ?>" class="vt-social-link" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($s['platform']); ?>">
                        <?php echo get_social_icon($s['platform']); ?>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="vt-identity-cta">
                <?php if ($contactLink): ?>
                <a href="<?php echo $contactLink; ?>" class="vt-btn vt-btn--primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <?php echo __t('vitae_contact'); ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($recentProjects)): ?>
                <a href="<?php echo cleanUrl('projects'); ?>" class="vt-btn vt-btn--outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?>
                </a>
                <?php endif; ?>
            </div>
            <?php if (!empty($skills)): ?>
            <div class="vt-identity-skills" aria-label="Skills">
                <?php foreach (array_slice($skills, 0, 6) as $sk): ?>
                <span class="vt-identity-skill-chip"><?php echo htmlspecialchars($sk['name']); ?></span>
                <?php endforeach; ?>
                <?php if (count($skills) > 6): ?>
                <span class="vt-identity-skill-chip">+<?php echo count($skills) - 6; ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: intro — bio if set, otherwise site description -->
        <div class="vt-intro vt-reveal vt-reveal--d1">
            <p class="vt-intro-eyebrow"><?php echo __t('vitae_hello'); ?></p>
            <h1 class="vt-intro-name"><?php echo htmlspecialchars($settings['site_title'] ?? ''); ?></h1>
            <p class="vt-intro-bio">
                <?php echo htmlspecialchars($bio !== '' ? $bio : ($settings['site_description'] ?? '')); ?>
            </p>
            <?php if (!empty($stats)): ?>
            <div class="vt-intro-stats">
                <?php foreach ($stats as $stat): ?>
                <div class="vt-stat">
                    <span class="vt-stat-value"><?php echo htmlspecialchars($stat['value']); ?></span>
                    <?php if ($stat['label']): ?>
                    <span class="vt-stat-label"><?php echo htmlspecialchars($stat['label']); ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="vt-intro-actions">
                <?php if ($showSkills): ?>
                <a href="#skills" class="vt-btn vt-btn--primary vt-btn--anchor">
                    <?php echo __t('vitae_my_skills'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                </a>
                <?php endif; ?>
                <?php if ($showTimeline): ?>
                <a href="#experience" class="vt-btn vt-btn--outline vt-btn--anchor">
                    <?php echo __t('vitae_my_experience'); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                </a>
                <?php endif; ?>
                <?php if (!$showSkills && !$showTimeline && $contactLink): ?>
                <a href="<?php echo $contactLink; ?>" class="vt-btn vt-btn--primary"><?php echo __t('vitae_contact'); ?></a>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php if (vitae_option('show_scroll_hint', true)): ?>
    <!-- Scroll indicator — links to the first section below the hero -->
    <a href="#<?php echo $firstSectionId; ?>" class="vt-scroll-hint" aria-label="<?php echo __t('vitae_scroll'); ?>">
        <span class="vt-scroll-track"></span>
        <span class="vt-scroll-label"><?php echo __t('vitae_scroll'); ?></span>
    </a>
    <?php endif; ?>

</section>

<!-- ══ SKILLS ══════════════════════════════════════════════════════════════ -->
<?php if ($showSkills): ?>
<section class="vt-section vt-section--skills" id="skills">
    <div class="vt-section-inner">
        <div class="vt-section-head vt-reveal">
            <span class="vt-label"><?php echo __t('vitae_skills'); ?></span>
        </div>
        <div class="vt-skills-wrap">
            <?php foreach ($skillCats as $catName): ?>
            <?php if (empty($skillsGrouped[$catName])) continue; ?>
            <div class="vt-skills-group vt-reveal">
                <h3 class="vt-skills-group-title"><?php echo htmlspecialchars($catName); ?></h3>
                <div class="vt-skills-list">
                    <?php foreach ($skillsGrouped[$catName] as $skill): ?>
                    <div class="vt-skill">
                        <div class="vt-skill-head">
                            <span class="vt-skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                            <span class="vt-skill-pct"><?php echo $skill['level']; ?>%</span>
                        </div>
                        <div class="vt-skill-track">
                            <div class="vt-skill-bar" style="--vt-skill-w:<?php echo $skill['level']; ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ TIMELINE ════════════════════════════════════════════════════════════ -->
<?php if ($showTimeline): ?>
<section class="vt-section vt-section--timeline" id="experience">
    <div class="vt-section-inner">
        <div class="vt-section-head vt-reveal">
            <span class="vt-label"><?php echo __t('vitae_experience'); ?></span>
        </div>
        <div class="vt-timeline-wrap vt-timeline-wrap--home">
            <?php foreach ($tlCats as $catName): ?>
            <?php if (empty($tlGrouped[$catName])) continue; ?>
            <section class="vt-tl-section vt-reveal">
                <h3 class="vt-tl-section-title"><?php echo htmlspecialchars($catName); ?></h3>
                <div class="vt-tl">
                    <?php foreach ($tlGrouped[$catName] as $entry): ?>
                    <div class="vt-tl-entry<?php echo $entry['current'] ? ' vt-tl-entry--current' : ''; ?>">
                        <div class="vt-tl-dot" aria-hidden="true"></div>
                        <div class="vt-tl-body">
                            <?php if ($entry['period']): ?>
                            <span class="vt-tl-period"><?php echo htmlspecialchars($entry['period']); ?></span>
                            <?php endif; ?>
                            <h4 class="vt-tl-title"><?php echo htmlspecialchars($entry['title']); ?></h4>
                            <?php if ($entry['org']): ?>
                            <span class="vt-tl-org"><?php echo htmlspecialchars($entry['org']); ?></span>
                            <?php endif; ?>
                            <?php if ($entry['desc']): ?>
                            <p class="vt-tl-desc"><?php echo htmlspecialchars($entry['desc']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ PROJECTS ════════════════════════════════════════════════════════════ -->
<?php if (!empty($recentProjects) && !empty($settings['show_projects_on_homepage'])): ?>
<section class="vt-section vt-section--projects" id="projects">
    <div class="vt-section-inner">
        <div class="vt-section-head vt-reveal">
            <span class="vt-label"><?php echo sl_type_label('project', true); ?></span>
            <a href="<?php echo cleanUrl('projects'); ?>" class="vt-more">
                <?php echo __t('view_all'); ?>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="vt-projects-grid">
            <?php foreach ($recentProjects as $i => $project): ?>
            <?php echo render_project_card($project); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ ARTICLES ════════════════════════════════════════════════════════════ -->
<?php if (!empty($recentArticles) && !empty($settings['show_articles_on_homepage'])): ?>
<section class="vt-section vt-section--articles" id="articles">
    <div class="vt-section-inner">
        <div class="vt-section-head vt-reveal">
            <span class="vt-label"><?php echo sl_type_label('article', true); ?></span>
            <a href="<?php echo cleanUrl('articles'); ?>" class="vt-more">
                <?php echo __t('view_all'); ?>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <ul class="vt-articles-list" role="list">
            <?php foreach ($recentArticles as $article): ?>
            <?php echo render_article_card($article); ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>

</div>
