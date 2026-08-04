/* =========================================================
   Home page interactions
   Source: public/js/pages-home.js
   ========================================================= */

(function () {
        const overlay = document.getElementById('publicationDetailOverlay');
        const title = document.getElementById('publicationDetailTitle');
        const date = document.getElementById('publicationDetailDate');
        const description = document.getElementById('publicationDetailDescription');
        const track = document.getElementById('publicationDetailTrack');
        const dots = document.getElementById('publicationDetailDots');
        const closeButton = document.getElementById('closePublicationDetail');
        const detailButtons = document.querySelectorAll('.js-publication-detail-btn');
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
                track.innerHTML = '<div class="publication-detail-slide"><img src="/assets/images/placeholders/no-image.svg" alt="Tidak ada gambar"></div>';
                track.style.transform = 'translateX(0)';
                return;
            }

            currentImages.forEach(function (item, index) {
                const slide = document.createElement('div');
                slide.className = 'publication-detail-slide';
                slide.innerHTML = '<img src="' + item.url + '" alt="Gambar publikasi ' + (index + 1) + '">';
                track.appendChild(slide);

                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'publication-detail-dot' + (index === currentIndex ? ' is-active' : '');
                dot.addEventListener('click', function () {
                    currentIndex = index;
                    track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
                    dots.querySelectorAll('.publication-detail-dot').forEach(function (dotEl, dotIndex) {
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

                title.textContent = button.dataset.judul || 'Detail Publikasi';
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
        const containers = document.querySelectorAll('.js-publication-tabs');
        if (!containers.length) return;

        function getPageSize(container) {
            const value = Number.parseInt(container.dataset.pageSize || '3', 10);
            return Number.isFinite(value) && value > 0 ? value : 3;
        }

        function renderGroupPage(group, page, pageSize) {
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
                    renderGroupPage(group, i, pageSize);
                });
                dotsWrap.appendChild(dot);
            }

            if (window.BatRefreshAnimations) {
                window.BatRefreshAnimations(group);
            }
        }

        function initContainer(container) {
            const menuButtons = container.querySelectorAll('.js-publication-menu');
            const groups = container.querySelectorAll('[data-publication-group]');
            const pageSize = getPageSize(container);
            if (!menuButtons.length || !groups.length) return;

            function activateTarget(target) {
            menuButtons.forEach(function (btn) {
                btn.classList.toggle('is-active', btn.getAttribute('data-target') === target);
            });

            groups.forEach(function (group) {
                const isActive = group.getAttribute('data-publication-group') === target;
                group.classList.toggle('is-active', isActive);
                if (isActive) {
                    renderGroupPage(group, 1, pageSize);
                    if (window.BatRefreshAnimations) {
                        window.BatRefreshAnimations(group);
                    }
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

            const activeButton = container.querySelector('.js-publication-menu.is-active') || menuButtons[0];
            if (activeButton) {
            const initialTarget = activeButton.getAttribute('data-target');
            if (initialTarget) {
                activateTarget(initialTarget);
            }
            }
        }

        containers.forEach(initContainer);
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
                pauseCurrentVideo();
                index = dotIndex;
                updateSlider();
            });
            dotsWrap.appendChild(dot);
        });
    }

    function pauseCurrentVideo() {
        const video = slides[index] && slides[index].querySelector('video');
        if (video) video.pause();
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
        pauseCurrentVideo();
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

    // Fullscreen lightbox for photo/video slides
    const lightbox = document.createElement('div');
    lightbox.className = 'buletin-lightbox js-buletin-lightbox';
    lightbox.setAttribute('role', 'dialog');
    lightbox.setAttribute('aria-modal', 'true');
    lightbox.setAttribute('aria-label', 'Tampilan penuh');
    lightbox.innerHTML =
        '<button type="button" class="buletin-lightbox-close" aria-label="Tutup">' +
            '<i class="fa-solid fa-xmark" aria-hidden="true"></i>' +
        '</button>' +
        '<button type="button" class="buletin-lightbox-nav buletin-lightbox-prev" aria-label="Sebelumnya">' +
            '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>' +
        '</button>' +
        '<div class="buletin-lightbox-stage"></div>' +
        '<button type="button" class="buletin-lightbox-nav buletin-lightbox-next" aria-label="Berikutnya">' +
            '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>' +
        '</button>';
    document.body.appendChild(lightbox);

    const stage = lightbox.querySelector('.buletin-lightbox-stage');
    const lbClose = lightbox.querySelector('.buletin-lightbox-close');
    const lbPrev = lightbox.querySelector('.buletin-lightbox-prev');
    const lbNext = lightbox.querySelector('.buletin-lightbox-next');
    let lbIndex = 0;

    function renderLightboxSlide() {
        const slideEl = slides[lbIndex];
        const sourceVideo = slideEl.querySelector('video');
        const sourceImg = slideEl.querySelector('img');
        stage.innerHTML = '';

        if (sourceVideo) {
            const video = document.createElement('video');
            video.src = sourceVideo.currentSrc || sourceVideo.src;
            if (sourceVideo.poster) video.poster = sourceVideo.poster;
            video.controls = true;
            video.autoplay = true;
            stage.appendChild(video);
        } else if (sourceImg) {
            const img = document.createElement('img');
            img.src = sourceImg.src;
            img.alt = sourceImg.alt || '';
            stage.appendChild(img);
        }

        const showNav = slides.length > 1;
        lbPrev.style.display = showNav ? '' : 'none';
        lbNext.style.display = showNav ? '' : 'none';
    }

    function openLightbox(slideIndex) {
        pauseCurrentVideo();
        lbIndex = slideIndex;
        renderLightboxSlide();
        lightbox.classList.add('is-open');
        document.body.classList.add('buletin-lightbox-open');
        lbClose.focus();
    }

    function closeLightbox() {
        stage.innerHTML = '';
        lightbox.classList.remove('is-open');
        document.body.classList.remove('buletin-lightbox-open');
    }

    function moveLightbox(direction) {
        lbIndex += direction;
        if (lbIndex < 0) lbIndex = slides.length - 1;
        if (lbIndex >= slides.length) lbIndex = 0;
        renderLightboxSlide();
    }

    slides.forEach(function (slideEl, slideIndex) {
        const expandButton = document.createElement('button');
        expandButton.type = 'button';
        expandButton.className = 'buletin-slide-expand';
        expandButton.setAttribute('aria-label', 'Perbesar tampilan');
        expandButton.innerHTML = '<i class="fa-solid fa-expand" aria-hidden="true"></i>';
        expandButton.addEventListener('click', function () {
            openLightbox(slideIndex);
        });
        slideEl.appendChild(expandButton);
    });

    lbClose.addEventListener('click', closeLightbox);
    lbPrev.addEventListener('click', function () { moveLightbox(-1); });
    lbNext.addEventListener('click', function () { moveLightbox(1); });

    lightbox.addEventListener('click', function (event) {
        if (event.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', function (event) {
        if (!lightbox.classList.contains('is-open')) return;
        if (event.key === 'Escape') closeLightbox();
        if (event.key === 'ArrowLeft') moveLightbox(-1);
        if (event.key === 'ArrowRight') moveLightbox(1);
    });
})();
