// Mobile: toggle submenu open/closed on click instead of following the link.
document.querySelectorAll('header nav li.has-submenu').forEach(function(item) {
	item.querySelector('a').addEventListener('click', function(e) {
		if (window.innerWidth <= 768) {
			e.preventDefault();
			this.parentNode.classList.toggle('mobile-expanded');
		}
	});
});
