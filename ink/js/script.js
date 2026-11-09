(function () {
    'use strict';

    var burger  = document.getElementById('ink-burger');
    var modal   = document.getElementById('ink-modal-nav');
    var overlay = document.getElementById('ink-overlay');

    if (!burger || !modal || !overlay) return;

    function openNav() {
        modal.classList.add('is-animating');
        requestAnimationFrame(function () {
            modal.classList.add('is-open');
        });
        modal.setAttribute('aria-hidden', 'false');
        modal.removeAttribute('inert');
        overlay.classList.add('is-visible');
        burger.setAttribute('aria-expanded', 'true');
        burger.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeNav() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('inert', '');
        overlay.classList.remove('is-visible');
        burger.setAttribute('aria-expanded', 'false');
        burger.classList.remove('is-open');
        document.body.style.overflow = '';
        setTimeout(function () {
            modal.classList.remove('is-animating');
        }, 620);
    }

    burger.addEventListener('click', function () {
        modal.classList.contains('is-open') ? closeNav() : openNav();
    });
    overlay.addEventListener('click', closeNav);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeNav();
    });

    /* ── Modal search ─────────────────────────────────────── */
    var searchInput   = document.getElementById('ink-modal-search-input');
    var searchResults = document.getElementById('ink-search-results');
    var searchClear   = document.getElementById('ink-search-clear');

    if (searchInput && searchResults) {
        var searchTimer = null;
        var searchCtrl  = null;
        var base        = (window.CMS_BASE_URL || '/');

        function closeResults() {
            searchResults.classList.remove('is-visible');
            searchResults.innerHTML = '';
        }

        function escapeRegex(str) {
            return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function renderResults(results, query) {
            searchResults.innerHTML = '';
            if (!results.length) {
                var empty = document.createElement('div');
                empty.className   = 'ink-search-empty';
                empty.textContent = (window.CMS_LANG && window.CMS_LANG['search_no_results']) || 'No results found.';
                searchResults.appendChild(empty);
                searchResults.classList.add('is-visible');
                return;
            }
            var re = new RegExp('(' + escapeRegex(query) + ')', 'gi');
            results.forEach(function (r) {
                var a = document.createElement('a');
                a.className = 'ink-search-result';
                a.href      = r.url;
                a.addEventListener('click', closeNav);

                var type = document.createElement('span');
                type.className   = 'ink-search-result-type';
                // Respects a renamed type (Settings -> Reading -> type_labels) via the
                // generic CMS_TYPE_LABELS island — see sl_type_labels_json() in
                // core/functions.php.
                type.textContent = (window.CMS_TYPE_LABELS && window.CMS_TYPE_LABELS[r.type]) || r.type;

                var title = document.createElement('span');
                title.className = 'ink-search-result-title';
                title.innerHTML = r.title.replace(re, '<mark>$1</mark>');

                a.appendChild(type);
                a.appendChild(title);
                searchResults.appendChild(a);
            });
            searchResults.classList.add('is-visible');
        }

        function doSearch(q) {
            if (searchCtrl) searchCtrl.abort();
            searchCtrl = new AbortController();
            fetch(
                base + 'core/search.php?q=' + encodeURIComponent(q) + '&articles=true&pages=true&projects=true&content=false',
                { signal: searchCtrl.signal }
            )
                .then(function (r) { return r.json(); })
                .then(function (data) { renderResults(data.results || [], q); })
                .catch(function () {});
        }

        searchInput.addEventListener('input', function () {
            var q = searchInput.value.trim();
            clearTimeout(searchTimer);
            if (searchClear) searchClear.hidden = q.length === 0;
            if (q.length < 2) { closeResults(); return; }
            searchTimer = setTimeout(function () { doSearch(q); }, 250);
        });

        if (searchClear) {
            searchClear.addEventListener('click', function () {
                searchInput.value = '';
                searchInput.focus();
                searchClear.hidden = true;
                closeResults();
            });
        }

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeResults();
                searchInput.value = '';
                if (searchClear) searchClear.hidden = true;
                return;
            }
            if (e.key === 'Enter') {
                e.preventDefault();
                var first = searchResults.querySelector('.ink-search-result');
                if (first) { closeNav(); window.location.href = first.href; }
            }
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                var items   = Array.prototype.slice.call(searchResults.querySelectorAll('.ink-search-result'));
                if (!items.length) return;
                var focused = searchResults.querySelector('.ink-search-result:focus');
                var idx     = items.indexOf(focused);
                var next    = e.key === 'ArrowDown'
                    ? items[idx < 0 ? 0 : Math.min(idx + 1, items.length - 1)]
                    : items[Math.max(idx - 1, 0)];
                next.focus();
            }
        });
    }

    /* ── Theme toggle ─────────────────────────────────────── */
    var themeToggle = document.getElementById('ink-theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            var current = document.documentElement.getAttribute('data-theme');
            var next    = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            try { localStorage.setItem('ink_theme', next); } catch(e) {}
        });
    }

    /* ── Back to top ─────────────────────────────────────── */
    var backTop = document.getElementById('ink-back-top');
    if (backTop) {
        var btTick = false;
        window.addEventListener('scroll', function () {
            if (btTick) return; btTick = true;
            requestAnimationFrame(function () {
                var show = window.scrollY > window.innerHeight * 0.6;
                if (show) {
                    backTop.removeAttribute('hidden');
                    requestAnimationFrame(function () { backTop.classList.add('is-visible'); });
                } else {
                    backTop.classList.remove('is-visible');
                }
                btTick = false;
            });
        }, { passive: true });
        backTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        // Re-hide after fade-out transition ends
        backTop.addEventListener('transitionend', function () {
            if (!backTop.classList.contains('is-visible')) {
                backTop.setAttribute('hidden', '');
            }
        });
    }

}());
