/**
 * SynaptikDocs Theme — script.js
 */
(function () {
    'use strict';

    var COLLAPSED_KEY = 'synaptikdocs_sidebar_collapsed';
    var burger         = document.getElementById('docs-burger');
    var sidebar        = document.getElementById('docs-sidebar');
    var overlay        = document.getElementById('sidebar-overlay');
    var collapseBtn    = document.getElementById('sidebar-collapse-btn');
    var sidebarToggle  = document.getElementById('docs-sidebar-toggle');

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('is-open');
        overlay && overlay.classList.add('is-visible');
        burger  && burger.classList.add('is-open');
        burger  && burger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('is-open');
        overlay && overlay.classList.remove('is-visible');
        burger  && burger.classList.remove('is-open');
        burger  && burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }
    burger  && burger.addEventListener('click', function () {
        sidebar && sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar();
    });
    overlay && overlay.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSidebar(); });

    function applySidebarCollapsed(collapsed) {
        document.body.classList.toggle('sidebar-collapsed', collapsed);
        try { localStorage.setItem(COLLAPSED_KEY, collapsed ? '1' : '0'); } catch(e) {}
    }
    try { if (localStorage.getItem(COLLAPSED_KEY) === '1') applySidebarCollapsed(true); } catch(e){}
    sidebarToggle && sidebarToggle.addEventListener('click', function () {
        applySidebarCollapsed(!document.body.classList.contains('sidebar-collapsed'));
    });
    collapseBtn && collapseBtn.addEventListener('click', function () {
        applySidebarCollapsed(!document.body.classList.contains('sidebar-collapsed'));
    });

    var GROUP_COLLAPSED_KEY = 'synaptikdocs_sidebar_collapsed_groups';
    var collapsedGroups;
    try { collapsedGroups = JSON.parse(localStorage.getItem(GROUP_COLLAPSED_KEY)) || []; }
    catch (e) { collapsedGroups = []; }

    function saveCollapsedGroups() {
        try { localStorage.setItem(GROUP_COLLAPSED_KEY, JSON.stringify(collapsedGroups)); } catch (e) {}
    }
    function setGroupCollapsed(id, collapsed) {
        var idx = collapsedGroups.indexOf(id);
        if (collapsed && idx === -1) collapsedGroups.push(id);
        else if (!collapsed && idx !== -1) collapsedGroups.splice(idx, 1);
        saveCollapsedGroups();
    }

    document.querySelectorAll('[data-group]').forEach(function (group) {
        var btn  = group.querySelector('.sidebar-group-btn');
        var list = group.querySelector('.sidebar-list');
        if (!btn || !list) return;

        var isActive = !!list.querySelector('a.active');
        if (isActive) group.classList.add('is-active');

        if (!isActive && collapsedGroups.indexOf(list.id) !== -1) {
            btn.setAttribute('aria-expanded', 'false');
            list.classList.add('is-collapsed');
        }

        btn.addEventListener('click', function () {
            var expanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', String(!expanded));
            list.classList.toggle('is-collapsed', expanded);
            setGroupCollapsed(list.id, expanded);
        });
    });

    if (sidebar) {
        var activeLink = sidebar.querySelector('[data-sidebar-link].active');
        if (activeLink) {
            setTimeout(function () { activeLink.scrollIntoView({ block: 'nearest' }); }, 80);
        }
    }

    var tocLinks = document.querySelectorAll('.toc-list a');
    if (tocLinks.length > 0) {
        var headings = [];
        tocLinks.forEach(function (link) {
            var href = link.getAttribute('href');
            var hash = href.indexOf('#') !== -1 ? href.substring(href.lastIndexOf('#') + 1) : '';
            var id = decodeURIComponent(hash);
            var el = document.getElementById(id);
            if (el) headings.push({ el: el, link: link });
        });
        var tocTick = false;
        function updateToc() {
            var current = null;
            for (var i = headings.length - 1; i >= 0; i--) {
                var top = headings[i].el.getBoundingClientRect().top;
                if (top <= 100) { current = headings[i]; break; }
            }
            tocLinks.forEach(function (l) { l.classList.remove('toc-active'); });
            if (current) current.link.classList.add('toc-active');
        }
        window.addEventListener('scroll', function () {
            if (tocTick) return; tocTick = true;
            requestAnimationFrame(function () { updateToc(); tocTick = false; });
        }, { passive: true });
        updateToc();
    }

    if (!document.body.classList.contains('is-list') && !document.body.classList.contains('is-home')) {
        var bar = document.createElement('div');
        bar.className = 'docs-progress';
        bar.setAttribute('aria-hidden', 'true');
        bar.innerHTML = '<div class="docs-progress-fill" id="dpf"></div>';
        document.body.appendChild(bar);
        var fill = document.getElementById('dpf');
        var ptick = false;
        function updateProgress() {
            var docH = document.documentElement.scrollHeight - window.innerHeight;
            var pct  = docH > 0 ? Math.min(100, (window.scrollY / docH) * 100) : 0;
            fill.style.width = pct + '%';
            bar.classList.toggle('is-visible', pct > 0);
        }
        window.addEventListener('scroll', function () {
            if (ptick) return; ptick = true;
            requestAnimationFrame(function () { updateProgress(); ptick = false; });
        }, { passive: true });
        updateProgress();
    }

    var themeToggle = document.getElementById('docs-theme-toggle');
    if (themeToggle) {
        var THEME_KEY = 'synaptikdocs_theme';
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            try { localStorage.setItem(THEME_KEY, theme); } catch(e) {}
        }
        themeToggle.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme');
            applyTheme(current === 'light' ? 'dark' : 'light');
        });
    }

    var docsSearchInput = document.getElementById('docs-nav-search');
    if (docsSearchInput) {
        var base  = (window.CMS_BASE_URL || '/');
        var tl    = function (key) { return (window.CMS_LANG && window.CMS_LANG[key]) ? window.CMS_LANG[key] : key; };
        var timer = null;
        var ctrl  = null;

        var drop = document.createElement('div');
        drop.id        = 'docs-search-drop';
        drop.className = 'docs-search-drop';
        drop.setAttribute('role', 'listbox');
        drop.setAttribute('aria-label', tl('search_results') || 'Search results');
        drop.setAttribute('hidden', '');
        docsSearchInput.parentElement.appendChild(drop);

        var clearBtn = document.getElementById('docs-search-clear');
        var kbdEl    = docsSearchInput.parentElement.querySelector('.docs-search-kbd');

        function closeDrop() {
            drop.style.opacity  = '0';
            drop.style.transform = 'translateY(-6px)';
            drop.style.pointerEvents = 'none';
            setTimeout(function () {
                drop.setAttribute('hidden', '');
                drop.innerHTML = '';
                drop.style.opacity = '';
                drop.style.transform = '';
            }, 180);
            docsSearchInput.setAttribute('aria-expanded', 'false');
            if (clearBtn) clearBtn.hidden = true;
            if (kbdEl) kbdEl.hidden = false;
        }

        function openDrop() {
            drop.removeAttribute('hidden');
            drop.style.pointerEvents = 'auto';
            drop.getBoundingClientRect();
            drop.style.opacity   = '1';
            drop.style.transform = 'translateY(0)';
            docsSearchInput.setAttribute('aria-expanded', 'true');
        }

        function escapeRegex(str) {
            return str.replace(/[-.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function renderResults(results, query) {
            drop.innerHTML = '';
            if (!results.length) {
                var msg = document.createElement('div');
                msg.className   = 'dsd-empty';
                msg.textContent = tl('search_no_results') || 'No results found.';
                drop.appendChild(msg);
                openDrop();
                return;
            }
            results.forEach(function (r) {
                var a = document.createElement('a');
                a.className = 'dsd-item';
                a.href      = r.url;
                a.setAttribute('role', 'option');

                var badge = document.createElement('span');
                badge.className   = 'dsd-type dsd-type--' + r.type;
                badge.textContent = (window.CMS_TYPE_LABELS && window.CMS_TYPE_LABELS[r.type + 's']) || r.type;

                var body = document.createElement('span');
                body.className = 'dsd-body';

                var title = document.createElement('span');
                title.className = 'dsd-title';
                title.innerHTML = r.title.replace(
                    new RegExp('(' + escapeRegex(query) + ')', 'gi'),
                    '<mark>$1</mark>'
                );
                body.appendChild(title);

                if (r.excerpt) {
                    var exc = document.createElement('span');
                    exc.className   = 'dsd-excerpt';
                    exc.textContent = r.excerpt;
                    body.appendChild(exc);
                }

                a.appendChild(badge);
                a.appendChild(body);
                drop.appendChild(a);
            });
            openDrop();
        }

        function doSearch(q) {
            if (ctrl) ctrl.abort();
            ctrl = new AbortController();
            fetch(
                base + 'search.php?q=' + encodeURIComponent(q) + '&articles=true&pages=true&projects=true&content=false',
                { signal: ctrl.signal }
            )
                .then(function (r) { return r.json(); })
                .then(function (data) { renderResults(data.results || [], q); })
                .catch(function () {});
        }

        docsSearchInput.addEventListener('input', function () {
            var q = docsSearchInput.value.trim();
            clearTimeout(timer);
            if (clearBtn) clearBtn.hidden = q.length === 0;
            if (kbdEl) kbdEl.hidden = q.length > 0;
            if (q.length < 2) { closeDrop(); return; }
            timer = setTimeout(function () { doSearch(q); }, 250);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                docsSearchInput.value = '';
                docsSearchInput.focus();
                if (kbdEl) kbdEl.hidden = false;
                closeDrop();
            });
        }

        docsSearchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeDrop(); docsSearchInput.blur(); return; }
            if (e.key === 'Enter') {
                e.preventDefault();
                var first = drop.querySelector('.dsd-item');
                if (first) window.location.href = first.href;
            }
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                var items   = Array.prototype.slice.call(drop.querySelectorAll('.dsd-item'));
                if (!items.length) return;
                var focused = drop.querySelector('.dsd-item:focus');
                var idx     = items.indexOf(focused);
                var next    = e.key === 'ArrowDown'
                    ? items[idx < 0 ? 0 : Math.min(idx + 1, items.length - 1)]
                    : items[Math.max(idx - 1, 0)];
                next.focus();
            }
        });

        document.addEventListener('click', function (e) {
            if (!docsSearchInput.parentElement.contains(e.target)) closeDrop();
        });
    }

}());