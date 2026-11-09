<?php /* Template Name: CV — Timeline */
/*
 * Timeline entries are entered in a single "Long text" custom field named "timeline"
 * in Settings → Custom Fields → Pages.
 *
 * Format — one entry per block, blocks separated by a blank line:
 *   Title | Organisation | Period | current
 *   Description (optional, second line)
 *
 * To start a new category section, use a line starting with ##:
 *   ## Experience
 *   ## Education
 *
 * The word "current" at the end of the first line marks the entry as current (accent dot).
 *
 * Example:
 *
 *   ## Experience
 *
 *   Lead Developer | Studio Neon | 2023 — Present | current
 *   Architected and shipped three client products from scratch.
 *
 *   Frontend Developer | Freelance | 2020 — 2023
 *   Built 20+ websites and web apps for clients across Europe.
 *
 *   ## Education
 *
 *   BSc Computer Science | University of Lyon | 2017 — 2020
 */
$cf      = $item['custom_fields'] ?? [];
$raw     = trim($cf['timeline'] ?? '');
$entries = [];
$cats    = [];
$curCat  = 'Experience';

if ($raw !== '') {
    $lines = explode("\n", $raw);
    $i     = 0;
    while ($i < count($lines)) {
        $line = trim($lines[$i]);

        // Category header
        if (strpos($line, '##') === 0) {
            $curCat = trim(substr($line, 2));
            if (!in_array($curCat, $cats, true)) $cats[] = $curCat;
            $i++;
            continue;
        }

        // Empty line
        if ($line === '') { $i++; continue; }

        // Entry first line: Title | Org | Period | current?
        $parts   = array_map('trim', explode('|', $line));
        $isCurrent = false;
        // Check if last part is the word "current"
        $last = strtolower(end($parts));
        if ($last === 'current') {
            $isCurrent = true;
            array_pop($parts);
        }
        $title  = $parts[0] ?? '';
        $org    = $parts[1] ?? '';
        $period = $parts[2] ?? '';

        // Optional second line = description
        $desc = '';
        if (isset($lines[$i + 1]) && trim($lines[$i + 1]) !== '' && strpos(trim($lines[$i + 1]), '##') !== 0 && strpos(trim($lines[$i + 1]), '|') === false) {
            $desc = trim($lines[$i + 1]);
            $i++;
        }

        if (!in_array($curCat, $cats, true)) $cats[] = $curCat;
        $entries[] = [
            'title'   => $title,
            'org'     => $org,
            'period'  => $period,
            'desc'    => $desc,
            'cat'     => $curCat,
            'current' => $isCurrent,
        ];
        $i++;
    }
}

$grouped = [];
foreach ($entries as $e) {
    $grouped[$e['cat']][] = $e;
}
?>
<article class="vt-single vt-tpl-timeline">
    <div class="vt-single-inner">

        <?php if (!isset($item['show_title']) || $item['show_title']): ?>
        <h1 class="vt-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
        <?php endif; ?>

        <?php if (!empty($item['content'])): ?>
        <div class="vt-prose vt-timeline-intro">
            <?php echo render_content_html($item['content'], $item); ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($entries)): ?>
        <div class="vt-timeline-wrap">
            <?php foreach ($cats as $catName): ?>
            <?php if (empty($grouped[$catName])) continue; ?>
            <section class="vt-tl-section vt-reveal">
                <h3 class="vt-tl-section-title"><?php echo htmlspecialchars($catName); ?></h3>
                <div class="vt-tl">
                    <?php foreach ($grouped[$catName] as $entry): ?>
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
        <?php else: ?>
        <div class="vt-prose">
            <p>Add a <strong>Long text</strong> custom field named <code>timeline</code> in Settings → Custom Fields → Pages, then fill it in the page editor.<br><br>
            Format: <code>Job title | Company | 2020 — 2023 | current</code></p>
        </div>
        <?php endif; ?>

    </div>
</article>
