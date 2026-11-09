/**
 * Portfolio Theme — script.js
 * Scroll-reveal, parallax covers, stagger animations.
 */

(function () {
    'use strict';

    // ── Scroll-reveal via IntersectionObserver ──────────────────────────────
    function initReveal() {
        if (!('IntersectionObserver' in window)) {
            // Fallback: make everything visible
            document.querySelectorAll('[data-reveal]').forEach(function (el) {
                el.classList.add('is-visible');
            });
            return;
        }

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    // Stagger siblings in the same grid
                    var siblings = Array.from(
                        (entry.target.parentElement || document).querySelectorAll('[data-reveal]:not(.is-visible)')
                    );
                    var idx = siblings.indexOf(entry.target);
                    var delay = Math.min(idx * 60, 320);
                    setTimeout(function () {
                        entry.target.classList.add('is-visible');
                    }, delay);
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            io.observe(el);
        });
    }

    // ── Parallax cover images ───────────────────────────────────────────────
    function initParallax() {
        var covers = document.querySelectorAll('[data-parallax] img');
        if (!covers.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        function update() {
            covers.forEach(function (img) {
                var rect  = img.closest('[data-parallax]').getBoundingClientRect();
                var ratio = (rect.top / window.innerHeight) * 0.3;
                img.style.transform = 'translateY(' + (ratio * 60) + 'px) scale(1.08)';
            });
        }

        window.addEventListener('scroll', update, { passive: true });
        update();
    }

    // ── Bento card tilt on hover ────────────────────────────────────────────
    function initTilt() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        if ('ontouchstart' in window) return; // skip on touch devices

        document.querySelectorAll('.bento-card').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var r    = card.getBoundingClientRect();
                var x    = (e.clientX - r.left) / r.width  - 0.5;
                var y    = (e.clientY - r.top)  / r.height - 0.5;
                var rotX = (-y * 6).toFixed(2);
                var rotY = ( x * 6).toFixed(2);
                card.style.transform = 'translateY(-5px) scale(1.01) perspective(800px) rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg)';
            });

            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
            });
        });
    }

    // ── Init ────────────────────────────────────────────────────────────────
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initReveal();
            initParallax();
            initTilt();
        });
    } else {
        initReveal();
        initParallax();
        initTilt();
    }
})();
