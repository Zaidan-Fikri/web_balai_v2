/* =========================================================
   Home page interactions
   Source: public/js/pages-home.js
   ========================================================= */

(function () {
        const overlay = document.getElementById('beritaDetailOverlay');
        const title = document.getElementById('beritaDetailTitle');
        const date = document.getElementById('beritaDetailDate');
        const description = document.getElementById('beritaDetailDescription');
        const track = document.getElementById('beritaDetailTrack');
        const dots = document.getElementById('beritaDetailDots');
        const closeButton = document.getElementById('closeBeritaDetail');
        const detailButtons = document.querySelectorAll('.js-berita-detail-btn');
        let currentIndex = 0;
        let currentImages = [];

        if (!overlay || !title || !date || !description || !track || !dots || !closeButton || !detailButtons.length) return;

        function decodeHtmlEntities(value) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = value;
            return textarea.value;
        }

        function parseImages(raw) {
            if (!raw) return [];
            try {
                const normalized = decodeHtmlEntities(String(raw));
                const parsed = JSON.parse(normalized);
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function renderSlider() {
            track.innerHTML = '';
            dots.innerHTML = '';

            if (!currentImages.length) {
                track.innerHTML = '<div class="berita-detail-slide"><img src="/assets/images/placeholders/no-image.svg" alt="Tidak ada gambar"></div>';
                track.style.transform = 'translateX(0)';
                return;
            }

            currentImages.forEach(function (item, index) {
                const slide = document.createElement('div');
                slide.className = 'berita-detail-slide';
                slide.innerHTML = '<img src="' + item.url + '" alt="Gambar berita ' + (index + 1) + '">';
                track.appendChild(slide);

                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'berita-detail-dot' + (index === currentIndex ? ' is-active' : '');
                dot.addEventListener('click', function () {
                    currentIndex = index;
                    track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
                    dots.querySelectorAll('.berita-detail-dot').forEach(function (dotEl, dotIndex) {
                        dotEl.classList.toggle('is-active', dotIndex === currentIndex);
                    });
                });
                dots.appendChild(dot);
            });

            dots.style.display = currentImages.length > 1 ? 'flex' : 'none';
            track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
        }

        function openOverlay() {
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
        }

        function closeOverlay() {
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
        }

        detailButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                currentImages = parseImages(button.dataset.images);
                currentIndex = 0;

                title.textContent = button.dataset.judul || 'Detail Berita';
                date.textContent = button.dataset.tanggal || '-';
                description.textContent = button.dataset.deskripsi || '-';
                renderSlider();

                openOverlay();
            });
        });

        closeButton.addEventListener('click', closeOverlay);

        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeOverlay();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && overlay.classList.contains('is-open')) {
                closeOverlay();
            }
        });
    })();

(function () {
        const menuButtons = document.querySelectorAll('.js-publication-menu');
        const groups = document.querySelectorAll('[data-publication-group]');
        if (!menuButtons.length || !groups.length) return;

        const pageSize = 3;

        function renderGroupPage(group, page) {
            const items = Array.from(group.querySelectorAll('.js-publication-item'));
            const dotsWrap = group.querySelector('.js-publication-dots');
            const totalPages = Math.ceil(items.length / pageSize);
            const safePage = Math.max(1, Math.min(page, Math.max(totalPages, 1)));
            group.dataset.currentPage = String(safePage);

            items.forEach(function (item, index) {
                const start = (safePage - 1) * pageSize;
                const end = safePage * pageSize;
                item.style.display = (index >= start && index < end) ? '' : 'none';
            });

            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            if (totalPages <= 1) {
                dotsWrap.style.display = 'none';
                return;
            }

            dotsWrap.style.display = 'flex';
            for (let i = 1; i <= totalPages; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'publication-dot' + (i === safePage ? ' is-active' : '');
                dot.addEventListener('click', function () {
                    renderGroupPage(group, i);
                });
                dotsWrap.appendChild(dot);
            }
        }

        function activateTarget(target) {
            menuButtons.forEach(function (btn) {
                btn.classList.toggle('is-active', btn.getAttribute('data-target') === target);
            });

            groups.forEach(function (group) {
                const isActive = group.getAttribute('data-publication-group') === target;
                group.classList.toggle('is-active', isActive);
                if (isActive) {
                    renderGroupPage(group, 1);
                }
            });
        }

        menuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const target = button.getAttribute('data-target');
                if (!target) return;
                activateTarget(target);
            });
        });

        const activeButton = document.querySelector('.js-publication-menu.is-active') || menuButtons[0];
        if (activeButton) {
            const initialTarget = activeButton.getAttribute('data-target');
            if (initialTarget) {
                activateTarget(initialTarget);
            }
        }
    })();

window.addEventListener('load', function () {
        const popup = document.getElementById('popup');
        if (popup) {
            setTimeout(function () {
                popup.style.display = 'block';
                setTimeout(function () {
                    popup.style.display = 'none';
                }, 8000);
            }, 0);
        }

        const siatabSlider = document.getElementById('siatabSwiper');
        const siatabPagination = document.getElementById('siatabPagination');
        const siatabActiveTitle = document.getElementById('siatabActiveTitle');
        if (!siatabSlider || typeof Swiper === 'undefined') {
            return;
        }

        const slideCount = siatabSlider.querySelectorAll('.swiper-slide').length;
        const useLoop = slideCount > 1;

        if (siatabPagination) {
            siatabPagination.style.display = useLoop ? 'block' : 'none';
        }

        function updateSiatabTitle(swiper) {
            if (!siatabActiveTitle || !swiper || !swiper.slides || !swiper.slides.length) return;
            const slide = swiper.slides[swiper.activeIndex];
            const title = slide ? slide.getAttribute('data-title') : '';
            siatabActiveTitle.textContent = title || 'SIATAB';
        }

        const siatabSwiper = new Swiper('#siatabSwiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: useLoop,
            speed: 700,
            grabCursor: true,
            allowTouchMove: useLoop,
            autoplay: useLoop ? {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            } : false,
            pagination: {
                el: '#siatabPagination',
                clickable: true
            },
            on: {
                init: function () {
                    updateSiatabTitle(this);
                },
                slideChange: function () {
                    updateSiatabTitle(this);
                }
            }
        });

        updateSiatabTitle(siatabSwiper);
    });

(function () {
    const slider = document.querySelector('.js-buletin-slider');
    if (!slider) return;

    const track = slider.querySelector('.js-buletin-slider-track');
    const prevButton = slider.querySelector('.js-buletin-slider-prev');
    const nextButton = slider.querySelector('.js-buletin-slider-next');
    const dotsWrap = slider.querySelector('.js-buletin-slider-dots');
    const slides = Array.from(slider.querySelectorAll('.buletin-slider-slide'));
    let index = 0;

    if (!track || !slides.length) return;

    function renderDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = '';
        if (slides.length <= 1) {
            dotsWrap.style.display = 'none';
            return;
        }

        dotsWrap.style.display = 'flex';
        slides.forEach(function (_, dotIndex) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'buletin-slider-dot' + (dotIndex === index ? ' is-active' : '');
            dot.setAttribute('aria-label', 'Tampilkan gambar ' + (dotIndex + 1));
            dot.addEventListener('click', function () {
                index = dotIndex;
                updateSlider();
            });
            dotsWrap.appendChild(dot);
        });
    }

    function updateSlider() {
        track.style.transform = 'translateX(-' + (index * 100) + '%)';
        if (dotsWrap) {
            dotsWrap.querySelectorAll('.buletin-slider-dot').forEach(function (dot, dotIndex) {
                dot.classList.toggle('is-active', dotIndex === index);
            });
        }
    }

    function move(direction) {
        index += direction;
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        updateSlider();
    }

    if (slides.length <= 1) {
        if (prevButton) prevButton.style.display = 'none';
        if (nextButton) nextButton.style.display = 'none';
    }

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            move(-1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            move(1);
        });
    }

    renderDots();
    updateSlider();
})();
