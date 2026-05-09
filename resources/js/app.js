/* =========================================================
   Global public layout
   Source: public/js/site-layout.js
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {
        var navbar = document.getElementById('siteNavbar');

        if (!navbar) {
            return;
        }

        var lastScrollY = window.scrollY;
        var revealZone = 100;
        var hideThreshold = 140;

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

        window.addEventListener('scroll', function () {
            var currentScrollY = window.scrollY;

            if (currentScrollY <= hideThreshold || currentScrollY < lastScrollY) {
                showNavbar();
            } else if (currentScrollY > lastScrollY) {
                hideNavbar();
            }

            lastScrollY = currentScrollY;
        }, { passive: true });

        document.addEventListener('mousemove', function (event) {
            if (event.clientY <= revealZone) {
                showNavbar();
            }
        });

        navbar.addEventListener('mouseenter', showNavbar);
    });
