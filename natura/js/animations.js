/**
 * Natura Theme — animations.js
 * Floating leaves, scroll reveal, header behavior, mobile hamburger menu
 *
 * NOTE: Collapsibles, tabs and open/close toggle bars are managed entirely by
 *       assets/js/features/collapsibles.js — do NOT duplicate them here.
 */
(function () {
  'use strict';

  /* ══════════════════════════════════════════════
     FLOATING LEAF PARTICLES — multi-color, subtle
  ══════════════════════════════════════════════ */
  const leafContainer = document.querySelector('.leaf-particles');
  const LEAF_COUNT = 12; // fewer, more elegant

  // Four pointed natural leaf silhouettes in a 24×24 viewbox
  const leafPaths = [
    'M12 1C9 5 8 9 8 13C8 17 10 21 12 23C14 21 16 17 16 13C16 9 15 5 12 1ZM12 1L12 23',
    'M12 2C8 5 6 9 7 14C8 18 10 21 12 22C14 21 16 18 17 13C18 9 16 5 12 2ZM12 2L12 22',
    'M12 0C10.5 4 10 8 10 12C10 16 10.5 20 12 24C13.5 20 14 16 14 12C14 8 13.5 4 12 0ZM12 0L12 24',
    'M12 3C7 6 5 10 6 14C7 18 9 20 12 21C15 20 17 18 18 14C19 10 17 6 12 3ZM12 3L12 21',
  ];

  // Palette: dark green · medium green · bright · sage/whitish · almost-white · very dark
  const leafColors = [
    '#3e8c3a',
    '#54b84f',
    '#78de72',
    '#b8ddb4',
    '#e8f5e6',
    '#1e4a1e',
  ];

  function randomBetween(a, b) {
    return a + Math.random() * (b - a);
  }

  function createLeaf() {
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 24 24');
    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    svg.classList.add('floating-leaf');

    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('d', leafPaths[Math.floor(Math.random() * leafPaths.length)]);
    path.setAttribute('fill', 'currentColor');
    svg.appendChild(path);

    const size = randomBetween(6, 18);
    svg.style.width  = size + 'px';
    svg.style.height = size + 'px';
    svg.style.left   = randomBetween(0, 100) + 'vw';
    svg.style.bottom = randomBetween(-60, -20) + 'px';

    // Per-leaf color via CSS color property (path uses fill="currentColor")
    svg.style.color = leafColors[Math.floor(Math.random() * leafColors.length)];

    // Variable opacity — some very faint, some more present
    svg.style.opacity = randomBetween(0.025, 0.12);

    const duration = randomBetween(14, 32);
    const delay    = -randomBetween(0, duration);

    svg.style.setProperty('--leaf-rot',   Math.random() > 0.5 ? '360deg' : '-360deg');
    svg.style.setProperty('--leaf-drift', randomBetween(-70, 70) + 'px');
    svg.style.animationDuration = duration + 's';
    svg.style.animationDelay    = delay + 's';

    leafContainer.appendChild(svg);
  }

  if (leafContainer) {
    for (let i = 0; i < LEAF_COUNT; i++) createLeaf();
  }

  /* ══════════════════════════════════════════════
     SCROLL REVEAL — IntersectionObserver
  ══════════════════════════════════════════════ */
  const revealSelectors = [
    '.article-card',
    '.project-card',
    '.content-details',
    '.page-details',
    '.project-details',
    '.home-hero',
    '.reveal',
  ];

  const revealEls = document.querySelectorAll(revealSelectors.join(','));

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.07, rootMargin: '0px 0px -30px 0px' }
    );
    revealEls.forEach((el) => {
      el.classList.add('reveal-init');
      observer.observe(el);
    });
  } else {
    revealEls.forEach((el) => el.classList.add('is-visible'));
  }

  /* ══════════════════════════════════════════════
     HEADER — scroll hide/show + blur
  ══════════════════════════════════════════════ */
  const header = document.getElementById('site-header');
  let lastScrollY = window.scrollY;
  let ticking = false;

  function onScroll() {
    const currentY = window.scrollY;
    if (header) {
      header.classList.toggle('scrolled', currentY > 40);
      if (currentY > lastScrollY + 4 && currentY > 200) {
        header.classList.add('header-hidden');
      } else if (currentY < lastScrollY - 4) {
        header.classList.remove('header-hidden');
      }
    }
    lastScrollY = currentY;
    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) { requestAnimationFrame(onScroll); ticking = true; }
  }, { passive: true });

  /* ══════════════════════════════════════════════
     MOBILE HAMBURGER MENU
     Collapsibles / tabs / submenu expand → assets/js/features/collapsibles.js
  ══════════════════════════════════════════════ */
  const navToggle = document.getElementById('nav-toggle');
  const siteNav   = document.getElementById('site-nav');

  function closeMenu() {
    if (!navToggle || !siteNav) return;
    navToggle.classList.remove('active');
    siteNav.classList.remove('nav-open');
    document.body.classList.remove('menu-open');
    navToggle.setAttribute('aria-expanded', 'false');
  }

  if (navToggle && siteNav) {
    navToggle.setAttribute('aria-expanded', 'false');

    navToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = siteNav.classList.toggle('nav-open');
      navToggle.classList.toggle('active', isOpen);
      document.body.classList.toggle('menu-open', isOpen);
      navToggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', (e) => {
      if (!siteNav.contains(e.target) && !navToggle.contains(e.target)) closeMenu();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu();
    });
  }

  /* ══════════════════════════════════════════════
     PARALLAX HEADER PLANT
  ══════════════════════════════════════════════ */
  const headerPlant = document.querySelector('.header-plant-svg');
  if (headerPlant) {
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      headerPlant.style.transform = `translateY(${y * 0.12}px) rotate(${-4 + y * 0.01}deg)`;
    }, { passive: true });
  }

  /* ══════════════════════════════════════════════
     ACTIVE NAV LINK — highlight current page
  ══════════════════════════════════════════════ */
  const currentUrl = window.location.href;
  document.querySelectorAll('.site-nav a').forEach((link) => {
    try {
      const href = new URL(link.href, window.location.origin).href;
      if (href === currentUrl || (href !== window.location.origin + '/' && currentUrl.startsWith(href))) {
        link.parentElement.classList.add('active');
      }
    } catch (err) { /* skip malformed URLs */ }
  });

})();