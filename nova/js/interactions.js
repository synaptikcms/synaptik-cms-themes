  document.addEventListener('DOMContentLoaded', function() {
    const burgerButton = document.querySelector('.burger-button');
    if (burgerButton) {
      burgerButton.addEventListener('click', function() {
        document.body.classList.toggle('menu-open');
        document.body.style.overflow = document.body.classList.contains('menu-open') ? 'hidden' : '';
      });
    }

    const header = document.querySelector('header');
    if (header) {
      window.addEventListener('scroll', function() {
        header.classList.toggle('scrolled', window.scrollY > 50);
      }, { passive: true });
    }

    document.querySelectorAll('.menu-link').forEach(link => {
      link.addEventListener('click', function() {
        if (!this.parentNode.classList.contains('has-submenu') || window.innerWidth <= 768) {
          document.body.classList.remove('menu-open');
          document.body.style.overflow = '';
        }
      });
    });

    const main = document.querySelector('main');
    if (main) main.classList.add('fade-in');

    document.querySelectorAll('.has-submenu').forEach(item => {
      item.querySelectorAll('ul > li').forEach((child, i) => {
        child.style.setProperty('--submenu-index', i);
      });
      const link = item.querySelector('a');
      link.addEventListener('click', function(e) {
        if (item.classList.contains('has-submenu')) {
          e.preventDefault();
          Array.from(item.parentNode.children)
            .filter(c => c !== item && c.classList.contains('has-submenu'))
            .forEach(s => s.classList.remove('submenu-open'));
          item.classList.toggle('submenu-open');
        }
      });
    });
  });

  // Fade-in on load + fade-out before navigating via pagination — was
  // assets/js/page-transitions.js (core, loaded on every theme regardless of
  // use); moved here since this theme actually styles .fade-in and uses
  // .pagination for its article-list pager.
  document.addEventListener('DOMContentLoaded', function() {
    var mainContent = document.querySelector('main');
    if (mainContent) mainContent.classList.add('fade-in');
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
  });
