<?php /* Template Name: CV — Skills */
/*
 * Skills are entered in a single "Long text" custom field named "skills"
 * in Settings → Custom Fields → Pages.
 *
 * Format — one skill per line:
 *   Skill name | level | Category name
 *
 * Example:
 *   PHP | 92 | Backend
 *   MySQL | 85 | Backend
 *   JavaScript | 88 | Frontend
 *   Figma | 80 | Design
 *
 * Rules:
 *   - Level is 0–100
 *   - Category name is free text; skills with the same category are grouped together
 *   - Lines starting with # are ignored (comments)
 *   - Empty lines are ignored
 */
$cf     = $item['custom_fields'] ?? [];
$raw    = trim($cf['skills'] ?? '');
$skills = [];
$cats   = [];

if ($raw !== '') {
    foreach (explode("\n", $raw) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        $parts = array_map('trim', explode('|', $line));
        if (count($parts) < 2) continue;
        $name  = $parts[0];
        $level = max(0, min(100, (int)$parts[1]));
        $cat   = isset($parts[2]) && $parts[2] !== '' ? $parts[2] : 'Skills';
        if (!in_array($cat, $cats, true)) $cats[] = $cat;
        $skills[] = ['name' => $name, 'level' => $level, 'cat' => $cat];
    }
}

$grouped = [];
foreach ($skills as $s) {
    $grouped[$s['cat']][] = $s;
}
?>
<article class="vt-single vt-tpl-skills">
    <div class="vt-single-inner">

        <?php if (!isset($item['show_title']) || $item['show_title']): ?>
        <h1 class="vt-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
        <?php endif; ?>

        <?php if (!empty($item['content'])): ?>
        <div class="vt-prose vt-skills-intro">
            <?php echo render_content_html($item['content'], $item); ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($skills)): ?>
        <div class="vt-skills-wrap">
            <?php foreach ($cats as $catName): ?>
            <?php if (empty($grouped[$catName])) continue; ?>
            <div class="vt-skills-group vt-reveal">
                <h3 class="vt-skills-group-title"><?php echo htmlspecialchars($catName); ?></h3>
                <div class="vt-skills-list">
                    <?php foreach ($grouped[$catName] as $skill): ?>
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
        <?php else: ?>
        <div class="vt-prose">
            <p>Add a <strong>Long text</strong> custom field named <code>skills</code> in Settings → Custom Fields → Pages, then fill it in the page editor.<br><br>
            One skill per line: <code>PHP | 90 | Backend</code></p>
        </div>
        <?php endif; ?>

    </div>
</article>
