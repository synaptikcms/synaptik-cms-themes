/**
 * Atrium Theme for Synaptik CMS — script.js
 *
 * Behavior:
 *   - Dark/light toggle with "ink spread" radial reveal
 *   - Mobile drawer
 *   - Soft custom cursor (desktop only, mix-blend on the cursor element)
 *   - Scroll reveal with automatic stagger on .atrium-stagger children
 *   - Hero word rotator
 *   - Curtain transition on internal navigation
 *   - Count-up for stat numbers
 *
 * The script is a single IIFE, no external dependencies, no globals leaked.
 */
(function () {
  'use strict';

  var df_reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var df_isCoarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;

  document.addEventListener('DOMContentLoaded', function () {
	df_initThemeToggle();
	df_initDrawer();
	df_initCursor();
	df_initReveal();
	df_initRotator();
	df_initCurtain();
	df_initCountUp();

	requestAnimationFrame(function () {
	  document.body.classList.add('atrium-loaded');
	});
  });

  /**
   * Dark/light toggle. Persists in localStorage. On click, animates an
   * "ink spread" radial gradient from the button position before swapping
   * the theme attribute, so the change reads as a single gesture.
   */
  function df_initThemeToggle() {
	var df_btn = document.getElementById('atrium-theme-toggle');
	if (!df_btn) return;

	df_btn.addEventListener('click', function (df_e) {
	  var df_current = document.documentElement.getAttribute('data-theme') || 'light';
	  var df_next = df_current === 'dark' ? 'light' : 'dark';

	  if (df_reduce) {
		df_applyTheme(df_next);
		return;
	  }

	  var df_rect = df_btn.getBoundingClientRect();
	  var df_x = df_rect.left + df_rect.width / 2;
	  var df_y = df_rect.top + df_rect.height / 2;
	  var df_radius = Math.hypot(
		Math.max(df_x, window.innerWidth - df_x),
		Math.max(df_y, window.innerHeight - df_y)
	  );

	  var df_ink = document.createElement('span');
	  df_ink.className = 'atrium-ink';
	  df_ink.style.left = df_x + 'px';
	  df_ink.style.top = df_y + 'px';
	  df_ink.style.setProperty('--df-ink-radius', df_radius + 'px');
	  // Ink color matches the destination background so the spread reads
	  // as the new theme "flooding" over the old one.
	  df_ink.style.background = df_next === 'dark' ? '#0e0e10' : '#f5f1ea';
	  document.body.appendChild(df_ink);

	  requestAnimationFrame(function () {
		df_ink.classList.add('is-expanding');
	  });

	  setTimeout(function () {
		df_applyTheme(df_next);
	  }, 280);

	  setTimeout(function () {
		df_ink.remove();
	  }, 700);
	});
  }

  function df_applyTheme(df_t) {
	document.documentElement.setAttribute('data-theme', df_t);
	try { localStorage.setItem('atrium-theme', df_t); } catch (df_e) {}
  }

  /**
   * Mobile drawer: opens via burger, closes via backdrop, link, or Escape.
   */
  function df_initDrawer() {
	var df_burger = document.getElementById('atrium-burger');
	var df_backdrop = document.getElementById('atrium-drawer-backdrop');
	var df_drawer = document.getElementById('atrium-drawer');
	if (!df_burger || !df_drawer) return;

	function df_open() {
	  df_drawer.classList.add('is-open');
	  if (df_backdrop) df_backdrop.classList.add('is-visible');
	  df_burger.setAttribute('aria-expanded', 'true');
	  df_drawer.setAttribute('aria-hidden', 'false');
	  df_drawer.removeAttribute('inert');
	  document.body.style.overflow = 'hidden';
	}
	function df_close() {
	  df_drawer.classList.remove('is-open');
	  if (df_backdrop) df_backdrop.classList.remove('is-visible');
	  df_burger.setAttribute('aria-expanded', 'false');
	  df_drawer.setAttribute('aria-hidden', 'true');
	  df_drawer.setAttribute('inert', '');
	  document.body.style.overflow = '';
	}

	df_burger.addEventListener('click', df_open);
	if (df_backdrop) df_backdrop.addEventListener('click', df_close);
	df_drawer.querySelectorAll('a').forEach(function (df_a) {
	  df_a.addEventListener('click', df_close);
	});
	document.addEventListener('keydown', function (df_e) {
	  if (df_e.key === 'Escape') df_close();
	});
  }

  /**
   * Soft circular cursor. Desktop pointer only. Grows on interactive
   * elements. Hidden by default if the device is coarse-pointer or the
   * user prefers reduced motion.
   */
  function df_initCursor() {
	var df_el = document.getElementById('atrium-cursor');
	if (!df_el || df_isCoarse || df_reduce) {
	  if (df_el) df_el.remove();
	  return;
	}

	var df_x = window.innerWidth / 2;
	var df_y = window.innerHeight / 2;
	var df_tx = df_x;
	var df_ty = df_y;
	var df_active = false;

	// Promote to its own compositor layer to reduce paint cost.
	df_el.style.willChange = 'transform';

	document.addEventListener('mousemove', function (df_e) {
	  df_tx = df_e.clientX;
	  df_ty = df_e.clientY;
	  if (!df_active) {
		df_active = true;
		df_el.classList.add('is-active');
	  }
	}, { passive: true });

	document.addEventListener('mouseleave', function () {
	  df_active = false;
	  df_el.classList.remove('is-active');
	});

	// Grow on interactive targets.
	var df_growSelector = 'a, button, [role="button"], input, textarea, label';
	document.addEventListener('mouseover', function (df_e) {
	  if (df_e.target.closest(df_growSelector)) {
		df_el.classList.add('is-grow');
	  }
	});
	document.addEventListener('mouseout', function (df_e) {
	  if (df_e.target.closest(df_growSelector)) {
		df_el.classList.remove('is-grow');
	  }
	});

	function df_tick() {
	  // Higher lerp factor = less lag. 0.38 keeps a subtle softness without
	  // feeling sluggish. Increase toward 1.0 for a near-instant snap.
	  df_x += (df_tx - df_x) * 0.38;
	  df_y += (df_ty - df_y) * 0.38;
	  df_el.style.transform = 'translate3d(' + (df_x - 12) + 'px,' + (df_y - 12) + 'px,0)';
	  requestAnimationFrame(df_tick);
	}
	requestAnimationFrame(df_tick);
  }

  /**
   * Reveal-on-scroll with IntersectionObserver. Elements with .atrium-reveal
   * fade and translate in. Children of .atrium-stagger get an incremental
   * delay so groups feel choreographed.
   */
  function df_initReveal() {
	if (df_reduce) {
	  // Reveal immediately — no animation.
	  document.querySelectorAll('.atrium-reveal, .atrium-stagger > *').forEach(function (df_el) {
		df_el.classList.add('is-visible');
	  });
	  return;
	}
	if (!('IntersectionObserver' in window)) {
	  document.querySelectorAll('.atrium-reveal, .atrium-stagger > *').forEach(function (df_el) {
		df_el.classList.add('is-visible');
	  });
	  return;
	}

	// Apply staggered delays once, before observation begins.
	document.querySelectorAll('.atrium-stagger').forEach(function (df_group) {
	  Array.prototype.forEach.call(df_group.children, function (df_child, df_idx) {
		df_child.classList.add('atrium-reveal');
		df_child.style.setProperty('--df-stagger', (df_idx * 60) + 'ms');
	  });
	});

	var df_io = new IntersectionObserver(function (df_entries) {
	  df_entries.forEach(function (df_entry) {
		if (df_entry.isIntersecting) {
		  df_entry.target.classList.add('is-visible');
		  df_io.unobserve(df_entry.target);
		}
	  });
	}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

	document.querySelectorAll('.atrium-reveal').forEach(function (df_el) {
	  df_io.observe(df_el);
	});
  }

  /**
   * Hero word rotator. Cycles .atrium-hero-word elements every 2200ms.
   */
  function df_initRotator() {
	var df_root = document.getElementById('atrium-rotator');
	if (!df_root) return;
	var df_words = df_root.querySelectorAll('.atrium-hero-word');
	if (df_words.length < 2) return;
	if (df_reduce) return; // Leave the first word visible.

	var df_idx = 0;
	setInterval(function () {
	  df_words[df_idx].classList.remove('is-active');
	  df_idx = (df_idx + 1) % df_words.length;
	  df_words[df_idx].classList.add('is-active');
	}, 2200);
  }

  /**
   * Curtain transition on internal navigation. Intercepts clicks on
   * [data-atrium-link], plays the curtain animation, then lets the
   * browser navigate. External links, modified clicks (ctrl/shift/meta),
   * downloads, and same-page hash links are left alone.
   */
  function df_initCurtain() {
	var df_curtain = document.getElementById('atrium-curtain');
	if (!df_curtain || df_reduce) {
	  // No transition: just hide the curtain immediately.
	  if (df_curtain) df_curtain.classList.add('is-hidden');
	  return;
	}

	// On every page load the curtain starts covering the screen (translateY(0)).
	// A single rAF lets the browser paint once before we trigger the lift,
	// so the transition is actually visible.
	requestAnimationFrame(function () {
	  requestAnimationFrame(function () {
		df_curtain.classList.add('is-hidden');
	  });
	});

	document.addEventListener('click', function (df_e) {
	  var df_a = df_e.target.closest('[data-atrium-link]');
	  if (!df_a) return;
	  if (df_e.metaKey || df_e.ctrlKey || df_e.shiftKey || df_e.altKey) return;
	  if (df_a.target && df_a.target !== '_self') return;
	  if (df_a.hasAttribute('download')) return;

	  var df_href = df_a.getAttribute('href') || '';
	  if (!df_href || df_href.indexOf('#') === 0) return;
	  if (df_href.indexOf('mailto:') === 0 || df_href.indexOf('tel:') === 0) return;

	  try {
		var df_url = new URL(df_href, window.location.href);
		if (df_url.origin !== window.location.origin) return;
		if (df_url.pathname === window.location.pathname && df_url.search === window.location.search) return;
	  } catch (df_err) { return; }

	  df_e.preventDefault();
	  // Drop the curtain down over the current page.
	  df_curtain.classList.remove('is-hidden');
	  setTimeout(function () {
		window.location.href = df_href;
	  }, 440);
	});
  }

  /**
   * Count up numeric stats marked with [data-atrium-count] when they enter
   * the viewport. Reads the final value from data-target.
   */
  function df_initCountUp() {
	var df_nodes = document.querySelectorAll('[data-atrium-count]');
	if (!df_nodes.length) return;

	if (df_reduce || !('IntersectionObserver' in window)) {
	  df_nodes.forEach(function (df_n) { df_n.textContent = df_n.getAttribute('data-target') || '0'; });
	  return;
	}

	var df_io = new IntersectionObserver(function (df_entries) {
	  df_entries.forEach(function (df_entry) {
		if (!df_entry.isIntersecting) return;
		var df_el = df_entry.target;
		df_io.unobserve(df_el);
		var df_target = parseInt(df_el.getAttribute('data-target') || '0', 10);
		var df_dur = 1200;
		var df_start = performance.now();
		function df_step(df_now) {
		  var df_t = Math.min(1, (df_now - df_start) / df_dur);
		  // easeOutCubic
		  var df_eased = 1 - Math.pow(1 - df_t, 3);
		  df_el.textContent = String(Math.round(df_target * df_eased));
		  if (df_t < 1) requestAnimationFrame(df_step);
		}
		requestAnimationFrame(df_step);
	  });
	}, { threshold: 0.4 });

	df_nodes.forEach(function (df_n) { df_io.observe(df_n); });
  }

})();