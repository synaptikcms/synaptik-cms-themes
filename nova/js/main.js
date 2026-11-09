/**
 * Nova Theme - A vibrant, animated theme with modern interactions
 * Author: Claude
 * 
 * Main JavaScript file for the Nova theme
 */

(function() {
  'use strict';

  // Initialize all components when the DOM is ready
  document.addEventListener('DOMContentLoaded', function() {
	initBurgerMenu();
	enhanceSubmenuFunctionality();
	initScrollEffects();
	initCustomCursor();
	initParallaxEffect();
	initSearchFunctionality();
	initLightbox();
	
	// Add loaded class to body after a short delay to trigger initial animations
	setTimeout(function() {
	  document.body.classList.add('content-loaded');
	}, 100);
  });
  
  /**
   * Enhanced menu functionality for submenu toggling
   */
  function enhanceSubmenuFunctionality() {
	// Find all submenu items
	const submenuItems = document.querySelectorAll('.has-submenu');
	
	// Set index for each submenu item child for staggered animation
	submenuItems.forEach(submenu => {
	  const submenuChildren = submenu.querySelectorAll('ul > li');
	  submenuChildren.forEach((child, index) => {
		child.style.setProperty('--submenu-index', index);
	  });
	});
	
	// Add click event to toggle submenu visibility
	submenuItems.forEach(item => {
	  const link = item.querySelector('a');
	  
	  link.addEventListener('click', function(e) {
		// Prevent navigation if this is a parent item with submenu
		if (item.classList.contains('has-submenu')) {
		  e.preventDefault();
		  
		  // Check if any other submenu is open at the same level
		  const siblings = Array.from(item.parentNode.children).filter(child => 
			child !== item && child.classList.contains('has-submenu')
		  );
		  
		  // Close other open submenus at the same level
		  siblings.forEach(sibling => {
			sibling.classList.remove('submenu-open');
		  });
		  
		  // Toggle this submenu
		  item.classList.toggle('submenu-open');
		}
	  });
	});
  }
  
  /**
   * Initialize burger menu and overlay navigation
   */
  function initBurgerMenu() {
	const burgerButton = document.querySelector('.burger-button');
	const menuItems = document.querySelectorAll('.menu-item');
	
	if (!burgerButton) return;
	
	// Set initial index for staggered animation
	menuItems.forEach((item, index) => {
	  item.style.setProperty('--index', index);
	});

	burgerButton.addEventListener('click', function() {
	  document.body.classList.toggle('menu-open');
	  
	  // Toggle overflow on body to prevent scrolling when menu is open
	  if (document.body.classList.contains('menu-open')) {
		document.body.style.overflow = 'hidden';
	  } else {
		document.body.style.overflow = '';
	  }
	});

	// Close menu when clicking on a menu link
	const menuLinks = document.querySelectorAll('.menu-link');
	menuLinks.forEach(link => {
	  link.addEventListener('click', function() {
		document.body.classList.remove('menu-open');
		document.body.style.overflow = '';
	  });
	});

	// Close menu when pressing ESC key
	document.addEventListener('keydown', function(e) {
	  if (e.key === 'Escape' && document.body.classList.contains('menu-open')) {
		document.body.classList.remove('menu-open');
		document.body.style.overflow = '';
	  }
	});
  }

  /**
   * Initialize scroll effects including fade-in animations and header state
   */
  function initScrollEffects() {
	const header = document.querySelector('header');
	const animatedElements = document.querySelectorAll('.fade-in-section, .fade-in-left, .fade-in-right, .scale-in');
	let lastScrollPosition = 0;
	const scrollThreshold = 100; // Pixels to scroll before header changes

	// Check elements in viewport on load
	checkElementsInViewport();

	// Add scroll event listener
	window.addEventListener('scroll', function() {
	  const currentScrollPosition = window.pageYOffset;
	  
	  // Change header appearance on scroll
	  if (header && currentScrollPosition > scrollThreshold) {
		header.classList.add('header-scrolled');
	  } else if (header) {
		header.classList.remove('header-scrolled');
	  }
	  
	  // Update last scroll position
	  lastScrollPosition = currentScrollPosition;
	  
	  // Check for elements in viewport
	  checkElementsInViewport();
	});

	// Function to check if elements are in viewport and add visible class
	function checkElementsInViewport() {
	  animatedElements.forEach(element => {
		if (isInViewport(element)) {
		  element.classList.add('is-visible');
		}
	  });
	}

	// Helper function to check if element is in viewport
	function isInViewport(element) {
	  const rect = element.getBoundingClientRect();
	  const windowHeight = window.innerHeight || document.documentElement.clientHeight;
	  
	  // Element is considered in viewport if it's top is in view or if it's taking most of the viewport
	  return (
		rect.top <= windowHeight * 0.8 && 
		rect.bottom >= 0
	  );
	}
  }

  /**
   * Initialize custom cursor functionality
   */
  function initCustomCursor() {
	const isMobile = window.matchMedia('(max-width: 768px)').matches;
	
	// Don't initialize custom cursor on mobile devices
	if (isMobile) return;
	
	// Create cursor elements
	const cursorOuter = document.createElement('div');
	cursorOuter.className = 'custom-cursor';
	
	const cursorDot = document.createElement('div');
	cursorDot.className = 'cursor-dot';
	
	// Add cursors to the DOM
	document.body.appendChild(cursorOuter);
	document.body.appendChild(cursorDot);
	
	// Variables for cursor position
	let mouseX = 0;
	let mouseY = 0;
	let cursorX = 0;
	let cursorY = 0;
	
	// Update mouse position
	document.addEventListener('mousemove', function(e) {
	  mouseX = e.clientX;
	  mouseY = e.clientY;
	});
	
	// Add hover effect for interactive elements
	const interactiveElements = document.querySelectorAll('a, button, input, textarea, select, .gallery-image, .article-card, .project-card');
	
	interactiveElements.forEach(element => {
	  element.addEventListener('mouseenter', function() {
		cursorOuter.classList.add('hover');
	  });
	  
	  element.addEventListener('mouseleave', function() {
		cursorOuter.classList.remove('hover');
	  });
	});
	
	// Animation loop for smooth cursor movement
	function animateCursor() {
	  // Calculate smooth movement with easing
	  const easeAmount = 0.2;
	  
	  cursorX += (mouseX - cursorX) * easeAmount;
	  cursorY += (mouseY - cursorY) * easeAmount;
	  
	  // Apply positions to cursor elements
	  cursorOuter.style.transform = `translate(${cursorX}px, ${cursorY}px)`;
	  cursorDot.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
	  
	  requestAnimationFrame(animateCursor);
	}
	
	// Start the animation loop
	animateCursor();
	
	// Hide default cursor
	document.body.style.cursor = 'none';
	
	// Show default cursor when leaving window
	document.addEventListener('mouseout', function(e) {
	  if (e.relatedTarget === null) {
		document.body.style.cursor = 'auto';
		cursorOuter.style.display = 'none';
		cursorDot.style.display = 'none';
	  }
	});
	
	// Show custom cursor when entering window
	document.addEventListener('mouseover', function() {
	  document.body.style.cursor = 'none';
	  cursorOuter.style.display = 'block';
	  cursorDot.style.display = 'block';
	});
  }

  /**
   * Initialize parallax effect for elements with parallax-bg class
   */
  function initParallaxEffect() {
	const parallaxElements = document.querySelectorAll('.parallax-bg');
	
	if (parallaxElements.length === 0) return;
	
	// Handle scroll for parallax effect
	window.addEventListener('scroll', function() {
	  const scrollPosition = window.pageYOffset;
	  
	  parallaxElements.forEach(element => {
		const speed = element.getAttribute('data-speed') || 0.5;
		const yPos = -(scrollPosition * speed);
		element.style.transform = `translateY(${yPos}px)`;
	  });
	});
  }

  /**
   * Initialize search functionality
   */
  function initSearchFunctionality() {
	// This integrates with the existing search functionality from the CMS
	// and enhances it with animations and transitions
	
	// Check if search elements exist
	const searchOverlay = document.getElementById('search-overlay');
	const searchToggle = document.getElementById('search-toggle');
	const closeSearch = document.getElementById('close-search');
	
	if (!searchOverlay || !searchToggle) return;
	
	// Add smooth opening/closing animations to search overlay
	searchToggle.addEventListener('click', function(e) {
	  e.preventDefault();
	  searchOverlay.style.display = 'flex';
	  
	  // Use setTimeout to ensure display takes effect before transitions
	  setTimeout(() => {
		searchOverlay.classList.add('active');
	  }, 10);
	  
	  // Focus the search input if it exists
	  const searchInput = document.getElementById('search-input');
	  if (searchInput) searchInput.focus();
	});
	
	if (closeSearch) {
	  closeSearch.addEventListener('click', function() {
		searchOverlay.classList.remove('active');
		
		// Wait for transition to complete before hiding
		setTimeout(() => {
		  searchOverlay.style.display = 'none';
		}, 400);
	  });
	}
	
	// Close when clicking outside the search container
	searchOverlay.addEventListener('click', function(e) {
	  if (e.target === searchOverlay) {
		searchOverlay.classList.remove('active');
		
		// Wait for transition to complete before hiding
		setTimeout(() => {
		  searchOverlay.style.display = 'none';
		}, 400);
	  }
	});
	
	// Add keyboard shortcut (Ctrl/Cmd + K) to open search
	document.addEventListener('keydown', function(e) {
	  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
		e.preventDefault();
		
		if (searchOverlay.classList.contains('active')) {
		  searchOverlay.classList.remove('active');
		  setTimeout(() => {
			searchOverlay.style.display = 'none';
		  }, 400);
		} else {
		  searchOverlay.style.display = 'flex';
		  setTimeout(() => {
			searchOverlay.classList.add('active');
			const searchInput = document.getElementById('search-input');
			if (searchInput) searchInput.focus();
		  }, 10);
		}
	  }
	  
	  // Allow closing with Escape key
	  if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
		searchOverlay.classList.remove('active');
		setTimeout(() => {
		  searchOverlay.style.display = 'none';
		}, 400);
	  }
	});
  }

  /**
   * Enhanced lightbox functionality with animations
   */
  function initLightbox() {
	// Get all gallery images
	const galleryImages = document.querySelectorAll('a[data-lightbox], .gallery-image a, .gallery-grid a');
	
	// Exit if no gallery images found
	if (!galleryImages.length) return;
	
	// Create lightbox container if it doesn't exist
	if (!document.getElementById('lightbox-container')) {
	  const lightboxContainer = document.createElement('div');
	  lightboxContainer.id = 'lightbox-container';
	  lightboxContainer.innerHTML = `
		<div id="lightbox-overlay"></div>
		<div id="lightbox-content">
		  <button id="lightbox-close">&times;</button>
		  <div id="lightbox-image-container">
			<img id="lightbox-image" src="" alt="">
		  </div>
		  <div id="lightbox-caption"></div>
		  <button id="lightbox-prev">&#10094;</button>
		  <button id="lightbox-next">&#10095;</button>
		</div>
	  `;
	  
	  document.body.appendChild(lightboxContainer);
	}
	
	// Get lightbox elements
	const lightboxContainer = document.getElementById('lightbox-container');
	const lightboxImage = document.getElementById('lightbox-image');
	const lightboxCaption = document.getElementById('lightbox-caption');
	const lightboxClose = document.getElementById('lightbox-close');
	const lightboxPrev = document.getElementById('lightbox-prev');
	const lightboxNext = document.getElementById('lightbox-next');
	
	// Lightbox state variables
	let currentGallery = [];
	let currentIndex = 0;
	
	// Add click event to each gallery image
	galleryImages.forEach(image => {
	  image.addEventListener('click', function(e) {
		e.preventDefault();
		openLightbox(image.href, image.getAttribute('data-title') || '');
	  });
	});
	
	// Lightbox functions
	function openLightbox(src, caption) {
	  lightboxImage.src = src;
	  lightboxCaption.textContent = caption;
	  
	  // Store gallery and index
	  currentGallery = getCurrentGallery(src);
	  currentIndex = getCurrentIndex(src);
	  
	  // Show lightbox
	  lightboxContainer.classList.add('active');
	  
	  // Disable scrolling on body
	  document.body.style.overflow = 'hidden';
	}
	
	function closeLightbox() {
	  lightboxContainer.classList.remove('active');
	  
	  // Reset image after transition
	  setTimeout(() => {
		lightboxImage.src = '';
	  }, 300);
	  
	  // Re-enable scrolling
	  document.body.style.overflow = '';
	}
	
	function getCurrentGallery(src) {
	  // Find current image
	  const currentImage = document.querySelector(`a[href="${src}"]`);
	  
	  if (!currentImage) return [];
	  
	  // Find all images in the same gallery
	  let gallery;
	  
	  // Check if it has a data-lightbox attribute for named galleries
	  const galleryName = currentImage.getAttribute('data-lightbox');
	  
	  if (galleryName) {
		gallery = Array.from(document.querySelectorAll(`a[data-lightbox="${galleryName}"]`));
	  } else {
		// Otherwise get all gallery images
		gallery = Array.from(galleryImages);
	  }
	  
	  return gallery;
	}
	
	function getCurrentIndex(src) {
	  if (!currentGallery || !currentGallery.length) {
		return 0;
	  }
	  
	  return currentGallery.findIndex(item => item.href === src);
	}
	
	function nextImage() {
	  if (!currentGallery || !currentGallery.length) return;
	  
	  currentIndex = (currentIndex + 1) % currentGallery.length;
	  const nextItem = currentGallery[currentIndex];
	  
	  // Fancy transition for next image
	  lightboxImage.style.opacity = '0';
	  lightboxImage.style.transform = 'translateX(20px)';
	  
	  setTimeout(() => {
		lightboxImage.src = nextItem.href;
		lightboxCaption.textContent = nextItem.getAttribute('data-title') || '';
		
		// Reset and fade in new image
		setTimeout(() => {
		  lightboxImage.style.opacity = '1';
		  lightboxImage.style.transform = 'translateX(0)';
		}, 50);
	  }, 300);
	}
	
	function prevImage() {
	  if (!currentGallery || !currentGallery.length) return;
	  
	  currentIndex = (currentIndex - 1 + currentGallery.length) % currentGallery.length;
	  const prevItem = currentGallery[currentIndex];
	  
	  // Fancy transition for previous image
	  lightboxImage.style.opacity = '0';
	  lightboxImage.style.transform = 'translateX(-20px)';
	  
	  setTimeout(() => {
		lightboxImage.src = prevItem.href;
		lightboxCaption.textContent = prevItem.getAttribute('data-title') || '';
		
		// Reset and fade in new image
		setTimeout(() => {
		  lightboxImage.style.opacity = '1';
		  lightboxImage.style.transform = 'translateX(0)';
		}, 50);
	  }, 300);
	}
	
	// Event listeners
	if (lightboxClose) {
	  lightboxClose.addEventListener('click', closeLightbox);
	}
	
	if (lightboxOverlay = document.getElementById('lightbox-overlay')) {
	  lightboxOverlay.addEventListener('click', closeLightbox);
	}
	
	if (lightboxPrev) {
	  lightboxPrev.addEventListener('click', prevImage);
	}
	
	if (lightboxNext) {
	  lightboxNext.addEventListener('click', nextImage);
	}
	
	// Keyboard navigation
	document.addEventListener('keydown', e => {
	  if (!lightboxContainer.classList.contains('active')) return;
	  
	  if (e.key === 'Escape') {
		closeLightbox();
	  } else if (e.key === 'ArrowRight') {
		nextImage();
	  } else if (e.key === 'ArrowLeft') {
		prevImage();
	  }
	});
  }

  /**
   * Page transitions for smooth navigation
   */
  function initPageTransitions() {
	// Select all internal links
	const internalLinks = document.querySelectorAll('a[href^="' + window.location.origin + '"], a[href^="/"], a[href^="./"], a[href^="../"], a[href^="#"]');
	
	internalLinks.forEach(link => {
	  // Skip links with specific classes or attributes
	  if (link.classList.contains('no-transition') || 
		  link.getAttribute('data-no-transition') === 'true' ||
		  link.getAttribute('target') === '_blank' ||
		  link.getAttribute('href').startsWith('#')) {
		return;
	  }
	  
	  link.addEventListener('click', function(e) {
		const href = this.getAttribute('href');
		
		// Don't handle if modifier keys are pressed
		if (e.metaKey || e.ctrlKey || e.shiftKey) return;
		
		e.preventDefault();
		
		// Animate the page out
		document.body.classList.add('page-transitioning-out');
		
		// Wait for animation and navigate
		setTimeout(() => {
		  window.location.href = href;
		}, 400);
	  });
	});
	
	// Add a class to the body when page loads
	window.addEventListener('pageshow', function() {
	  document.body.classList.add('page-transitioning-in');
	  
	  // Remove the class after animation completes
	  setTimeout(() => {
		document.body.classList.remove('page-transitioning-in');
	  }, 500);
	});
  }
}());