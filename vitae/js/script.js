/* Vitae Theme — script.js */
(function () {
    'use strict';

    // ── Theme toggle (dark / light) ──────────────────────────────────────────
    function initThemeToggle() {
        var btn = document.getElementById('vt-theme-toggle');
        if (!btn) return;

        // Sync button state with current data-theme (set by inline script in <head>)
        function syncBtn() {
            var isDark = document.documentElement.getAttribute('data-theme') !== 'light';
            btn.setAttribute('aria-pressed', String(!isDark));
        }
        syncBtn();

        btn.addEventListener('click', function () {
            var isLight = document.documentElement.getAttribute('data-theme') === 'light';
            if (isLight) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('vt-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('vt-theme', 'light');
            }
            syncBtn();
        });
    }

    // ── Scroll reveal ────────────────────────────────────────────────────────
    function initReveal() {
        var els = document.querySelectorAll('.vt-reveal');
        if (!els.length || !window.IntersectionObserver) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        els.forEach(function (el) { io.observe(el); });
    }

    // ── Typewriter ───────────────────────────────────────────────────────────
    function initTypewriter() {
        var el = document.querySelector('.vt-tw');
        if (!el) return;

        var raw   = el.getAttribute('data-words') || '';
        var words = raw.indexOf('|') !== -1
            ? raw.split('|').map(function (w) { return w.trim(); }).filter(Boolean)
            : [raw];

        if (!words.length) return;
        if (words.length === 1) { el.textContent = words[0]; return; }

        var wi = 0, ci = 0, del = false;

        function tick() {
            var w = words[wi];
            if (del) {
                el.textContent = w.slice(0, --ci);
                if (ci === 0) { del = false; wi = (wi + 1) % words.length; setTimeout(tick, 380); return; }
                setTimeout(tick, 38);
            } else {
                el.textContent = w.slice(0, ++ci);
                if (ci === w.length) { del = true; setTimeout(tick, 1900); return; }
                setTimeout(tick, 72);
            }
        }
        setTimeout(tick, 700);
    }

    // ── Mobile nav ───────────────────────────────────────────────────────────
    function initNav() {
        var burger = document.getElementById('vt-burger');
        var nav    = document.getElementById('vt-sidenav');
        if (!burger || !nav) return;

        var overlay = document.createElement('div');
        overlay.className = 'vt-overlay';
        document.body.appendChild(overlay);

        function open() {
            nav.classList.add('is-open');
            burger.classList.add('is-open');
            burger.setAttribute('aria-expanded', 'true');
            overlay.style.display = 'block';
            requestAnimationFrame(function () { overlay.classList.add('is-visible'); });
            document.body.style.overflow = 'hidden';
        }
        function close() {
            nav.classList.remove('is-open');
            burger.classList.remove('is-open');
            burger.setAttribute('aria-expanded', 'false');
            overlay.classList.remove('is-visible');
            setTimeout(function () { overlay.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        }

        burger.addEventListener('click', function () {
            nav.classList.contains('is-open') ? close() : open();
        });
        overlay.addEventListener('click', close);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && nav.classList.contains('is-open')) close();
        });
    }

    // ── Highlight current nav link ───────────────────────────────────────────
    function initActiveLink() {
        var path = window.location.pathname;
        document.querySelectorAll('.vt-nav-menu a').forEach(function (a) {
            if (a.getAttribute('href') === path) {
                var li = a.closest('li');
                if (li) li.classList.add('current');
            }
        });
    }

    // ── Scroll hint smooth scroll with admin bar offset ──────────────────────
    function initScrollHint() {
        var hint = document.querySelector('.vt-scroll-hint');
        if (!hint) return;
        hint.addEventListener('click', function (e) {
            var targetId = hint.getAttribute('href').replace('#', '');
            var target   = document.getElementById(targetId);
            if (!target) return;
            e.preventDefault();
            var adminBar = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--snk-adminbar-height'), 10) || 0;
            var top = target.getBoundingClientRect().top + window.scrollY - adminBar;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initThemeToggle();
        initReveal();
        initTypewriter();
        initNav();
        initActiveLink();
        initScrollHint();
    });

}());
