/**
 * Axion Theme for Synaptik CMS — script.js
 * Floating pill header (compact-on-scroll), mobile menu, hover/tap dropdowns,
 * IntersectionObserver reveal, smooth in-page anchor scroll.
 */
(function () {
  'use strict';

  // Pill header: shrink/compact when scrolled.
  var header = document.getElementById('ax-header');
  if (header) {
    var onScroll = function () {
      if (window.scrollY > 12) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Mobile burger toggle.
  var burger = document.getElementById('ax-burger');
  var nav = document.getElementById('ax-nav');
  if (burger && nav) {
    burger.addEventListener('click', function () {
      var open = document.body.classList.toggle('ax-nav-open');
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Dropdown submenu: hover on desktop (CSS), tap-to-open on mobile.
  nav && nav.querySelectorAll('.has-submenu > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        link.parentNode.classList.toggle('submenu-open');
      }
    });
  });

  // Close mobile nav after tapping a leaf link.
  nav && nav.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () {
      if (a.parentNode.classList.contains('has-submenu')) return;
      if (window.innerWidth <= 900) {
        document.body.classList.remove('ax-nav-open');
        burger && burger.setAttribute('aria-expanded', 'false');
      }
    });
  });

  // Reveal-on-scroll.
  if ('IntersectionObserver' in window) {
    var revealEls = document.querySelectorAll('[data-reveal]');
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    document.querySelectorAll('[data-reveal]').forEach(function (el) {
      el.classList.add('is-revealed');
    });
  }

  // Smooth scroll for in-page anchors.
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (id.length <= 1) return;
      var target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  // Fade out before navigating via pagination — was assets/js/page-transitions.js
  // (core, loaded on every theme regardless of use); moved here since this
  // theme is one of the few whose pagination actually uses .pagination.
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
})();
