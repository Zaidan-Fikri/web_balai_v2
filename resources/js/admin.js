/* =========================================================
   Admin layout
   Source: public/js/admin-layout.js
   ========================================================= */

(function () {
        const shell = document.getElementById('adminShell');
        const toggle = document.getElementById('sidebarToggle');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (!shell || !toggle) return;

        function isMobile() {
            return window.matchMedia('(max-width: 1120px)').matches;
        }

        function closeMobileSidebar() {
            shell.classList.remove('mobile-sidebar-open');
            document.body.classList.remove('mobile-sidebar-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', function () {
            if (isMobile()) {
                shell.classList.toggle('mobile-sidebar-open');
                document.body.classList.toggle('mobile-sidebar-open', shell.classList.contains('mobile-sidebar-open'));
                toggle.setAttribute('aria-expanded', shell.classList.contains('mobile-sidebar-open') ? 'true' : 'false');
                if (shell.classList.contains('mobile-sidebar-open')) {
                    const target = getIndicatorTarget();
                    if (target) {
                        placeIndicator(target, false);
                    }
                }
                return;
            }

            shell.classList.toggle('collapsed');
            toggle.setAttribute('aria-expanded', shell.classList.contains('collapsed') ? 'false' : 'true');
        });

        if (backdrop) {
            backdrop.addEventListener('click', closeMobileSidebar);
        }

        const menu = document.querySelector('.sidebar-menu');
        const indicator = document.getElementById('menuActiveIndicator');
        const menuLinks = menu ? menu.querySelectorAll('a.menu-item, button.menu-item') : [];
        const menuGroups = menu ? menu.querySelectorAll('.menu-group') : [];

        function isVisible(target) {
            return Boolean(target && target.offsetParent !== null);
        }

        function getIndicatorTarget() {
            if (!menu) return null;
            const active = menu.querySelector('.menu-item.active');
            if (!active) return null;
            const group = active.closest('.menu-group');
            if (group && (!group.open || !isVisible(active))) {
                return group.querySelector('.menu-group-toggle');
            }
            return active;
        }

        function placeIndicator(target, animate) {
            if (!menu || !indicator) return;
            if (!target) return;
            const menuRect = menu.getBoundingClientRect();
            const itemRect = target.getBoundingClientRect();
            indicator.style.transition = animate ? 'top .25s ease, height .25s ease, opacity .18s ease' : 'none';
            indicator.style.top = (itemRect.top - menuRect.top) + 'px';
            indicator.style.height = itemRect.height + 'px';
            indicator.style.opacity = '1';
            if (!animate) {
                requestAnimationFrame(function () {
                    indicator.style.transition = 'top .25s ease, height .25s ease, opacity .18s ease';
                });
            }
        }

        if (menu && indicator && menuLinks.length) {
            const initialTarget = getIndicatorTarget();
            if (initialTarget) {
                placeIndicator(initialTarget, false);
            }
        }

        menuGroups.forEach(function (group) {
            group.addEventListener('toggle', function () {
                requestAnimationFrame(function () {
                    const target = getIndicatorTarget();
                    if (target) {
                        placeIndicator(target, true);
                    }
                });
            });
        });

        menuLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                if (isMobile()) {
                    event.preventDefault();
                    const currentActiveMobile = menu.querySelector('.menu-item.active');
                    if (currentActiveMobile) {
                        currentActiveMobile.classList.remove('active');
                    }
                    link.classList.add('active');
                    placeIndicator(link, true);
                    window.setTimeout(function () {
                        closeMobileSidebar();
                        window.location.href = link.href;
                    }, 180);
                    return;
                }
                event.preventDefault();

                const currentActive = menu.querySelector('.menu-item.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }
                link.classList.add('active');
                placeIndicator(link, true);

                window.setTimeout(function () {
                    window.location.href = link.href;
                }, 180);
            });
        });

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                closeMobileSidebar();
                const target = getIndicatorTarget();
                if (target) {
                    placeIndicator(target, false);
                }
            } else if (shell.classList.contains('collapsed')) {
                shell.classList.remove('collapsed');
            }
        });
    })();

(function () {
    const searchInput = document.querySelector('.topbar .search input');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {
        const keyword = searchInput.value.trim().toLowerCase();

        document.querySelectorAll('.table-wrap tbody').forEach(function (tbody) {
            tbody.querySelectorAll('tr').forEach(function (row) {
                const isEmptyRow = row.querySelector('td[colspan]');

                if (isEmptyRow) {
                    row.classList.remove('is-hidden-row');
                    return;
                }

                const rowText = row.textContent.toLowerCase();
                row.classList.toggle('is-hidden-row', keyword !== '' && !rowText.includes(keyword));
            });
        });
    });
})();
