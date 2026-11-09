/**
 * Vanta Theme — script.js
 * Read-progress bar, mobile nav drawer, active nav state.
 */
(function () {
  'use strict';

  /* ── Read progress bar ──────────────────────────────────── */
  const progressBar = document.getElementById('vanta-progress');

  function updateProgress() {
    if (!progressBar) return;
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    progressBar.style.width  = docHeight <= 0 ? '0' : Math.min(100, (scrollTop / docHeight) * 100) + '%';
    progressBar.style.opacity = scrollTop > 0 ? '1' : '0';
  }

  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();

  /* ── Mobile nav burger ──────────────────────────────────── */
  const burger = document.getElementById('vanta-burger');
  const drawer = document.getElementById('vanta-drawer');

  if (burger && drawer) {
    burger.addEventListener('click', function () {
      const isOpen = drawer.classList.toggle('is-open');
      burger.classList.toggle('is-open', isOpen);
      burger.setAttribute('aria-expanded', String(isOpen));
    });

    drawer.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        drawer.classList.remove('is-open');
        burger.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* ── Active nav link ────────────────────────────────────── */
  // renderHierarchicalMenu() outputs <li> items — we add is-active on the <li>,
  // not the <a>, so the CSS selector `.nav-links > ul > li.is-active > a` fires.
  const currentPath = window.location.pathname;

  function markActive(container) {
    if (!container) return;
    container.querySelectorAll('li > a').forEach(function (link) {
      try {
        const href = link.getAttribute('href');
        if (!href || href === '#') return;
        const linkPath = new URL(href, window.location.origin).pathname;
        // Exact match for home (/), prefix match for everything else
        const isHome  = linkPath === '/' || linkPath === '';
        const matches = isHome
          ? currentPath === linkPath
          : currentPath.startsWith(linkPath) && linkPath.length > 1;
        if (matches) {
          link.parentElement.classList.add('is-active');
        }
      } catch (e) { /* ignore cross-origin hrefs */ }
    });
  }

  markActive(document.querySelector('.nav-links'));
  markActive(document.getElementById('vanta-drawer'));

  /* ── Nav search — inline dropdown ──────────────────────── */
  const navSearchInput = document.getElementById('vanta-nav-search');
  if (navSearchInput) {
      const base    = (window.CMS_BASE_URL || '/');
      const t       = (key) => window.CMS_LANG?.[key] ?? key;
      let   timer   = null;
      let   current = null; // active XHR/fetch abort controller
  
      // Create dropdown element
      const drop = document.createElement('div');
      drop.id        = 'vanta-search-drop';
      drop.className = 'vanta-search-drop';
      drop.setAttribute('role', 'listbox');
      drop.setAttribute('aria-label', t('search_results') || 'Search results');
      navSearchInput.parentElement.appendChild(drop);
  
      function closeDrop() {
          drop.hidden = true;
          drop.innerHTML = '';
          navSearchInput.setAttribute('aria-expanded', 'false');
      }
  
      function renderResults(results, query) {
          drop.innerHTML = '';
          if (!results.length) {
              const msg = document.createElement('div');
              msg.className = 'vsd-empty';
              msg.textContent = t('search_no_results') || 'No results found.';
              drop.appendChild(msg);
              drop.hidden = false;
              return;
          }
          results.forEach(function (r) {
              const a = document.createElement('a');
              a.className = 'vsd-item';
              a.href = r.url;
              a.setAttribute('role', 'option');
              const badge = document.createElement('span');
              badge.className = 'vsd-type vsd-type--' + r.type;
              // Respects a renamed type (Settings -> Reading -> type_labels) via the
              // generic CMS_TYPE_LABELS island render_header_scripts() always emits —
              // see sl_type_labels_json() in core/functions.php.
              badge.textContent = (window.CMS_TYPE_LABELS && window.CMS_TYPE_LABELS[r.type]) || r.type;
              const body = document.createElement('span');
              body.className = 'vsd-body';
              const title = document.createElement('span');
              title.className = 'vsd-title';
              // Highlight query in title
              title.innerHTML = r.title.replace(
                  new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi'),
                  '<mark>$1</mark>'
              );
              body.appendChild(title);
              if (r.excerpt) {
                  const exc = document.createElement('span');
                  exc.className = 'vsd-excerpt';
                  exc.textContent = r.excerpt;
                  body.appendChild(exc);
              }
              a.appendChild(badge);
              a.appendChild(body);
              drop.appendChild(a);
          });
          drop.hidden = false;
          navSearchInput.setAttribute('aria-expanded', 'true');
      }
  
      function doSearch(q) {
          if (current) current.abort();
          current = new AbortController();
          const url = base + 'search.php?q=' + encodeURIComponent(q)
              + '&articles=true&pages=true&projects=true&content=false';
          fetch(url, { signal: current.signal })
              .then(function (r) { return r.json(); })
              .then(function (data) { renderResults(data.results || [], q); })
              .catch(function () {});
      }
  
      navSearchInput.addEventListener('input', function () {
          const q = navSearchInput.value.trim();
          clearTimeout(timer);
          if (q.length < 2) { closeDrop(); return; }
          timer = setTimeout(function () { doSearch(q); }, 250);
      });
  
      navSearchInput.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') { closeDrop(); navSearchInput.blur(); return; }
          if (e.key === 'Enter') {
              e.preventDefault();
              const first = drop.querySelector('.vsd-item');
              if (first) window.location.href = first.href;
          }
          // Arrow key navigation
          if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
              e.preventDefault();
              const items = [...drop.querySelectorAll('.vsd-item')];
              if (!items.length) return;
              const focused = drop.querySelector('.vsd-item:focus');
              const idx = items.indexOf(focused);
              const next = e.key === 'ArrowDown'
                  ? items[idx < 0 ? 0 : Math.min(idx + 1, items.length - 1)]
                  : items[Math.max(idx - 1, 0)];
              next.focus();
          }
      });
  
      document.addEventListener('click', function (e) {
          if (!navSearchInput.parentElement.contains(e.target)) closeDrop();
      });
  }

})();
