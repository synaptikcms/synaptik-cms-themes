(function () {
	var s = document.currentScript;
	if (!s) return;
	var key = s.getAttribute('data-key');
	if (!key) return;
	var mode = s.getAttribute('data-mode') || 'attr';
	var only = s.getAttribute('data-only');
	var fallback = s.getAttribute('data-fallback');
	try {
		var v = localStorage.getItem(key);
		var shouldApply = false;
		if (only !== null) {
			shouldApply = (v === only);
		} else if (v) {
			shouldApply = true;
		} else if (fallback === 'system') {
			v = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
			shouldApply = true;
		} else if (fallback) {
			v = fallback;
			shouldApply = true;
		}
		if (!shouldApply) return;
		if (mode === 'class') {
			document.body.classList.add(s.getAttribute('data-class') || v);
		} else {
			document.documentElement.setAttribute(s.getAttribute('data-attr') || 'data-theme', v);
		}
	} catch (e) {}
})();
