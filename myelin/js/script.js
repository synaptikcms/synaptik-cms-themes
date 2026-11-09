/**
 * Myelin Theme for Synaptik CMS — script.js
 * Header scroll state, mobile nav toggle, hover/tap submenu, and reveal-on-scroll.
 */
(function () {
  'use strict';

  // Header solidifies on scroll.
  var header = document.getElementById('my-header');
  if (header) {
    var onScroll = function () {
      if (window.scrollY > 8) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Mobile nav toggle.
  var navToggle = document.getElementById('my-nav-toggle');
  var nav = document.getElementById('my-nav');
  if (navToggle && nav) {
    navToggle.addEventListener('click', function () {
      var open = document.body.classList.toggle('my-nav-open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Submenu: hover on desktop (CSS), tap-to-open on mobile.
  var subItems = document.querySelectorAll('.my-nav .has-submenu > a');
  subItems.forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth <= 900) {
        e.preventDefault();
        var parent = link.parentNode;
        parent.classList.toggle('submenu-open');
      }
    });
  });

  // Close mobile nav after tapping a leaf link.
  nav && nav.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () {
      if (a.parentNode.classList.contains('has-submenu')) return;
      if (window.innerWidth <= 900) {
        document.body.classList.remove('my-nav-open');
        navToggle && navToggle.setAttribute('aria-expanded', 'false');
      }
    });
  });

  // Subtle reveal-on-scroll with IntersectionObserver.
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
