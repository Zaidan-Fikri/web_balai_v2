/* =========================================================
   Global public layout
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('siteNavbar');
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    let ticking = false;

    function setScrollButtonState(isVisible) {
        if (!scrollTopBtn) {
            return;
        }

        scrollTopBtn.classList.toggle('is-visible', isVisible);
        scrollTopBtn.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
    }

    function updateScrolledState(currentScrollY) {
        if (!navbar) {
            return;
        }

        navbar.classList.toggle('is-scrolled', currentScrollY > 24);
    }

    function showNavbar() {
        if (!navbar) {
            return;
        }

        navbar.classList.remove('is-hidden');
        navbar.classList.add('is-visible');
    }

    function updateScrollUi() {
        const currentScrollY = Math.max(window.scrollY, 0);

        updateScrolledState(currentScrollY);
        setScrollButtonState(currentScrollY > 420);
        showNavbar();

        ticking = false;
    }

    function requestScrollUpdate() {
        if (ticking) {
            return;
        }

        ticking = true;
        window.requestAnimationFrame(updateScrollUi);
    }

    updateScrolledState(window.scrollY);
    setScrollButtonState(window.scrollY > 420);

    window.addEventListener('scroll', requestScrollUpdate, { passive: true });

    if (navbar) {
        navbar.addEventListener('mouseenter', showNavbar);
    }

    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: reduceMotion.matches ? 'auto' : 'smooth',
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const searchItem = document.querySelector('.nav-search-item');
    const searchToggle = document.getElementById('navbarSearchToggle');
    const searchForm = document.getElementById('navbarSearchForm');
    const searchInput = document.getElementById('navbarSearchInput');

    if (!searchItem || !searchToggle || !searchForm || !searchInput) {
        return;
    }

    function openSearch() {
        searchItem.classList.add('is-open');
        searchToggle.setAttribute('aria-expanded', 'true');
        window.requestAnimationFrame(() => searchInput.focus());
    }

    function closeSearch() {
        searchItem.classList.remove('is-open');
        searchToggle.setAttribute('aria-expanded', 'false');
    }

    searchToggle.addEventListener('click', () => {
        if (searchItem.classList.contains('is-open')) {
            closeSearch();
            return;
        }

        openSearch();
    });

    searchForm.addEventListener('submit', (event) => {
        if (searchInput.value.trim() === '') {
            event.preventDefault();
            openSearch();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSearch();
            searchToggle.focus();
        }
    });

    document.addEventListener('click', (event) => {
        if (!searchItem.contains(event.target)) {
            closeSearch();
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const textItems = Array.from(document.querySelectorAll('.bat-text-anime'));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (!textItems.length || reduceMotion) {
        textItems.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    if (!window.gsap || !window.SplitText) {
        textItems.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    textItems.forEach((item) => {
        if (item.dataset.batSplitReady === 'true') {
            return;
        }

        item.dataset.batSplitReady = 'true';

        const isHeroTitle = item.dataset.batAnime === 'hero';
        const split = new window.SplitText(item, {
            type: 'lines,words,chars',
            linesClass: 'split-line',
        });

        window.gsap.set(item, {
            opacity: 1,
            perspective: 400,
            visibility: 'visible',
        });

        window.gsap.set(split.chars, {
            opacity: 0,
            x: 50,
        });

        item.classList.add('is-ready');

        const config = {
            x: 0,
            y: 0,
            rotateX: 0,
            opacity: 1,
            duration: 1,
            ease: window.Back ? window.Back.easeOut : 'back.out(1.7)',
            stagger: 0.02,
            delay: isHeroTitle ? 1.25 : 0,
            onComplete: () => {
                item.classList.remove('is-ready');
                item.classList.add('is-visible');
            },
        };

        if (!isHeroTitle && window.ScrollTrigger) {
            config.scrollTrigger = {
                trigger: item,
                start: 'top 90%',
            };
        }

        window.gsap.to(split.chars, config);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const animatedItems = document.querySelectorAll('.wow, .reveal, .text-anime-style-3, .bat-text-anime');

    if (!animatedItems.length) {
        return;
    }

    let refreshTimer = null;

    function revealVisibleItems(scope = document) {
        const items = Array.from(scope.querySelectorAll('.wow, .reveal'));

        items.forEach((item) => {
            const rect = item.getBoundingClientRect();
            const isVisibleArea = rect.bottom >= 0 && rect.top <= window.innerHeight;

            if (isVisibleArea && window.getComputedStyle(item).visibility === 'hidden') {
                item.style.visibility = 'visible';
            }
        });
    }

    function refreshAnimations(scope = document) {
        window.clearTimeout(refreshTimer);
        refreshTimer = window.setTimeout(() => {
            revealVisibleItems(scope);

            if (window.ScrollTrigger) {
                window.ScrollTrigger.refresh(true);
            }

            window.dispatchEvent(new Event('scroll'));
        }, 80);
    }

    window.BatRefreshAnimations = refreshAnimations;

    refreshAnimations();
    window.addEventListener('load', () => refreshAnimations(), { once: true });
    window.setTimeout(() => refreshAnimations(), 600);
    window.setTimeout(() => refreshAnimations(), 1400);

    Array.from(document.images).forEach((image) => {
        if (image.complete) {
            return;
        }

        image.addEventListener('load', () => refreshAnimations(), { once: true });
        image.addEventListener('error', () => refreshAnimations(), { once: true });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('siteNavbar');
    const menu = document.getElementById('menu');

    if (!navbar || !menu) {
        return;
    }

    const desktopQuery = window.matchMedia('(min-width: 992px)');
    const submenus = Array.from(menu.querySelectorAll('.submenu'));
    const topItems = Array.from(menu.children);

    navbar.classList.add('has-menu-js');

    function getTrigger(item) {
        return Array.from(item.children).find((child) => child.matches('a.nav-link')) || null;
    }

    function getPanel(item) {
        return Array.from(item.children).find((child) => child.classList.contains('sub-menu')) || null;
    }

    function setExpanded(item, value) {
        const trigger = getTrigger(item);

        if (trigger) {
            trigger.setAttribute('aria-expanded', value ? 'true' : 'false');
        }
    }

    function closeBranch(item) {
        item.classList.remove('is-open', 'is-edge', 'is-flyout-left');
        setExpanded(item, false);

        item.querySelectorAll('.submenu').forEach((child) => {
            child.classList.remove('is-open', 'is-edge', 'is-flyout-left');
            setExpanded(child, false);
        });
    }

    function closeAll(except = null) {
        submenus.forEach((item) => {
            if (!except || (item !== except && !item.contains(except))) {
                closeBranch(item);
            }
        });
    }

    function keepPanelInViewport(item) {
        const panel = getPanel(item);

        if (!panel) {
            return;
        }

        item.classList.remove('is-edge', 'is-flyout-left');

        window.requestAnimationFrame(() => {
            const rect = panel.getBoundingClientRect();
            const viewportGap = 16;

            if (item.classList.contains('flyout-parent')) {
                item.classList.toggle('is-flyout-left', rect.right > window.innerWidth - viewportGap);
                return;
            }

            item.classList.toggle('is-edge', rect.right > window.innerWidth - viewportGap);
        });
    }

    function openMenu(item) {
        if (!desktopQuery.matches) {
            return;
        }

        closeAll(item);
        item.classList.add('is-open');
        setExpanded(item, true);
        keepPanelInViewport(item);
    }

    submenus.forEach((item) => {
        const trigger = getTrigger(item);

        if (trigger) {
            trigger.setAttribute('aria-haspopup', 'true');
            trigger.setAttribute('aria-expanded', 'false');

            trigger.addEventListener('click', (event) => {
                if (desktopQuery.matches && trigger.getAttribute('href') === '#') {
                    event.preventDefault();
                    trigger.blur();
                }
            });
        }

        item.addEventListener('pointerenter', () => openMenu(item));
        item.addEventListener('pointerleave', () => closeBranch(item));
    });

    topItems
        .filter((item) => !item.classList.contains('submenu'))
        .forEach((item) => {
            item.addEventListener('pointerenter', () => closeAll());
        });

    menu.addEventListener('pointerleave', () => {
        if (desktopQuery.matches) {
            closeAll();
        }
    });

    document.addEventListener('pointerdown', (event) => {
        if (desktopQuery.matches && !navbar.contains(event.target)) {
            closeAll();
        }
    });

    document.addEventListener('focusin', (event) => {
        if (desktopQuery.matches && !navbar.contains(event.target)) {
            closeAll();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAll();
        }
    });

    if (typeof desktopQuery.addEventListener === 'function') {
        desktopQuery.addEventListener('change', () => closeAll());
    } else {
        desktopQuery.addListener(() => closeAll());
    }
});
