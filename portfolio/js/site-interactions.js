(function () {
    // Mobile nav toggle
    const toggle = document.getElementById('nav-toggle');
    const nav    = document.getElementById('site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            nav.classList.toggle('is-open');
            document.body.classList.toggle('nav-open');
        });
    }

    // Mobile submenu support
    document.querySelectorAll('header nav li.has-submenu > a').forEach(function (a) {
        a.addEventListener('click', function (e) {
            if (window.innerWidth <= 900) {
                e.preventDefault();
                this.parentNode.classList.toggle('mobile-expanded');
            }
        });
    });

    // Header hide-on-scroll
    let lastScroll = 0;
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function () {
        const cur = window.scrollY;
        if (cur > 80) {
            header.classList.toggle('header-hidden', cur > lastScroll);
        } else {
            header.classList.remove('header-hidden');
        }
        lastScroll = cur;
    }, { passive: true });
})();
