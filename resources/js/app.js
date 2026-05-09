/* =========================================================
   Global public layout
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('siteNavbar');

    if (!navbar) {
        return;
    }

    let lastScrollY = window.scrollY;
    const revealZone = 100;
    const hideThreshold = 140;

    function updateScrolledState() {
        navbar.classList.toggle('is-scrolled', window.scrollY > 24);
    }

    function showNavbar() {
        navbar.classList.remove('is-hidden');
        navbar.classList.add('is-visible');
    }

    function hideNavbar() {
        if (window.scrollY <= hideThreshold) {
            return;
        }

        navbar.classList.remove('is-visible');
        navbar.classList.add('is-hidden');
    }

    showNavbar();
    updateScrolledState();

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;

        updateScrolledState();

        if (currentScrollY <= hideThreshold || currentScrollY < lastScrollY) {
            showNavbar();
        } else if (currentScrollY > lastScrollY) {
            hideNavbar();
        }

        lastScrollY = currentScrollY;
    }, { passive: true });

    document.addEventListener('mousemove', (event) => {
        if (event.clientY <= revealZone) {
            showNavbar();
        }
    });

    navbar.addEventListener('mouseenter', showNavbar);
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
