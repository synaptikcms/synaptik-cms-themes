/**
 * Prism Theme for Synaptik CMS — main.js
 * Dark/light toggle, nav indicator, left drawer, scroll reveal, search integration.
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    initThemeToggle();
    initDrawer();
    initNavIndicator();
    initScrollEffects();
    initSubmenus();
    initTagLinks();

    setTimeout(function () {
      document.body.classList.add('prism-loaded');
    }, 60);
  });

  /**
   * Dark / light mode toggle with localStorage persistence.
   */
  function initThemeToggle() {
    var btn = document.getElementById('prism-theme-toggle');
    if (!btn) return;

    function updateLabel(theme) {
      var labelKey = theme === 'dark' ? 'Light mode' : 'Dark mode';
      btn.setAttribute('aria-label', labelKey);
      btn.setAttribute('title', labelKey);
    }

    updateLabel(document.documentElement.getAttribute('data-theme') || 'light');

    btn.addEventListener('click', function () {
      var current = document.documentElement.getAttribute('data-theme') || 'light';
      var next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('prism-theme', next);
      updateLabel(next);
    });
  }

  /**
   * Left-side mobile drawer.
   */
  function initDrawer() {
    var burger   = document.getElementById('prism-burger');
    var backdrop = document.getElementById('prism-backdrop');
    var drawer   = document.getElementById('prism-drawer');

    if (!burger || !drawer) return;

    function openDrawer() {
      drawer.classList.add('is-open');
      backdrop.classList.add('is-visible');
      burger.setAttribute('aria-expanded', 'true');
      drawer.setAttribute('aria-hidden', 'false');
      drawer.removeAttribute('inert');
      document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      backdrop.classList.remove('is-visible');
      burger.setAttribute('aria-expanded', 'false');
      drawer.setAttribute('aria-hidden', 'true');
      drawer.setAttribute('inert', '');
      document.body.style.overflow = '';
    }

    burger.addEventListener('click', openDrawer);

    if (backdrop) backdrop.addEventListener('click', closeDrawer);

    document.querySelectorAll('.prism-drawer-link').forEach(function (link) {
      link.addEventListener('click', closeDrawer);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeDrawer();
    });
  }

  /**
   * Horizontal nav: sliding color indicator follows hovered link.
   */
  function initNavIndicator() {
    var nav       = document.getElementById('prism-nav');
    var indicator = document.getElementById('prism-indicator');
    if (!nav || !indicator) return;

    var links = nav.querySelectorAll('.prism-nav-link');
    var colors = [
      'var(--c1)', 'var(--c2)', 'var(--c3)', 'var(--c4)', 'var(--c5)'
    ];
    var colorIndex = 0;

    function moveIndicator(el) {
      var navRect = nav.getBoundingClientRect();
      var rect    = el.getBoundingClientRect();
      indicator.style.width   = rect.width + 'px';
      indicator.style.left    = (rect.left - navRect.left) + 'px';
      indicator.style.opacity = '1';
      indicator.style.background = colors[colorIndex % colors.length];
      colorIndex++;
    }

    links.forEach(function (link) {
      link.addEventListener('mouseenter', function () {
        moveIndicator(this);
      });
    });

    nav.addEventListener('mouseleave', function () {
      indicator.style.opacity = '0';
    });
  }

  /**
   * Scroll effects: header shadow and clip-path reveal on .prism-reveal elements.
   */
  function initScrollEffects() {
    var header = document.getElementById('prism-header');

    function onScroll() {
      if (header) {
        header.classList.toggle('is-scrolled', window.scrollY > 40);
      }
      revealElements();
    }

    function revealElements() {
      document.querySelectorAll('.prism-reveal:not(.is-visible)').forEach(function (el) {
        var rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.9) {
          el.classList.add('is-visible');
        }
      });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    revealElements();
  }

  /**
   * Desktop submenu toggle on click (for nested items with has-submenu class).
   */
  function initSubmenus() {
    document.querySelectorAll('.prism-nav .has-submenu').forEach(function (item) {
      var link = item.querySelector('.prism-nav-link');
      if (!link) return;

      link.addEventListener('click', function (e) {
        if (item.querySelector('ul')) {
          e.preventDefault();
          var siblings = Array.from(item.parentNode.children).filter(function (c) {
            return c !== item && c.classList.contains('has-submenu');
          });
          siblings.forEach(function (s) { s.classList.remove('submenu-open'); });
          item.classList.toggle('submenu-open');
        }
      });
    });

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.prism-nav .has-submenu')) {
        document.querySelectorAll('.prism-nav .has-submenu.submenu-open').forEach(function (item) {
          item.classList.remove('submenu-open');
        });
      }
    });
  }

  /**
   * Project card tag links sit inside the card's own <a> — stop the click
   * from bubbling to the card link so the tag navigates on its own.
   */
  function initTagLinks() {
    document.querySelectorAll('.tag-link').forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    });
  }

}());

// Fade out before navigating via pagination — was assets/js/page-transitions.js
// (core, loaded on every theme regardless of use); moved here since this
// theme is one of the few whose pagination actually uses .pagination.
(function () {
  'use strict';
  var mainContent = document.querySelector('main');
  document.querySelectorAll('.pagination a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var href = this.getAttribute('href');
      if (mainContent) {
        mainContent.style.opacity = 0;
        setTimeout(function () { window.location.href = href; }, 300);
      } else {
        window.location.href = href;
      }
    });
  });
}());
