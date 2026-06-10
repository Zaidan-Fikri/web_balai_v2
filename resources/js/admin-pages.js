/* Admin page interactions extracted from Blade templates. */

/* =========================================================
   resources/views/pages/admin/geolistrik-1d.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openGeolistrikPopup');
            const importButton = document.getElementById('openGeolistrikImportPopup');
            const importOverlay = document.getElementById('geolistrikImportOverlay');
            const importFile = document.getElementById('geolistrikImportFile');
            const importPreviewOverlay = document.getElementById('geolistrikImportPreviewOverlay');
            const createOverlay = document.getElementById('geolistrikCreateOverlay');
            const createKode = document.getElementById('createGeolistrikKode');
            const readOverlay = document.getElementById('geolistrikReadOverlay');
            const readNama = document.getElementById('readGeolistrikNama');
            const readKode = document.getElementById('readGeolistrikKode');
            const readKabKota = document.getElementById('readGeolistrikKabKota');
            const readKecamatan = document.getElementById('readGeolistrikKecamatan');
            const readDesaKelurahan = document.getElementById('readGeolistrikDesaKelurahan');
            const readUpt = document.getElementById('readGeolistrikUpt');
            const readLatitude = document.getElementById('readGeolistrikLatitude');
            const readLongitude = document.getElementById('readGeolistrikLongitude');
            const readElevasi = document.getElementById('readGeolistrikElevasi');
            const readTanggalAkusisiData = document.getElementById('readGeolistrikTanggalAkusisiData');
            const readGeologi = document.getElementById('readGeolistrikGeologi');
            const readCekunganAirTanah = document.getElementById('readGeolistrikCekunganAirTanah');
            const readHidrogeologi = document.getElementById('readGeolistrikHidrogeologi');
            const readLapisanPembawaAir = document.getElementById('readGeolistrikLapisanPembawaAir');
            const readPdf = document.getElementById('readGeolistrikPdf');
            const updateOverlay = document.getElementById('geolistrikUpdateOverlay');
            const updateForm = document.getElementById('geolistrikUpdateForm');
            const updateKode = document.getElementById('updateGeolistrikKode');
            const updateKabKota = document.getElementById('updateGeolistrikKabKota');
            const updateKecamatan = document.getElementById('updateGeolistrikKecamatan');
            const updateDesaKelurahan = document.getElementById('updateGeolistrikDesaKelurahan');
            const updateUpt = document.getElementById('updateGeolistrikUpt');
            const updateLatitude = document.getElementById('updateGeolistrikLatitude');
            const updateLongitude = document.getElementById('updateGeolistrikLongitude');
            const updateElevasi = document.getElementById('updateGeolistrikElevasi');
            const updateTanggalAkusisiData = document.getElementById('updateGeolistrikTanggalAkusisiData');
            const updateGeologi = document.getElementById('updateGeolistrikGeologi');
            const updateCekunganAirTanah = document.getElementById('updateGeolistrikCekunganAirTanah');
            const updateHidrogeologi = document.getElementById('updateGeolistrikHidrogeologi');
            const updateLapisanPembawaAir = document.getElementById('updateGeolistrikLapisanPembawaAir');
            const updatePdfCurrent = document.getElementById('updateGeolistrikPdfCurrent');
            const updatePdfFile = document.getElementById('updateGeolistrikPdfFile');

            if (!openButton || !createOverlay || !createKode) return;

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            openButton.addEventListener('click', function () {
                openOverlay(createOverlay, createKode);
            });

            if (importButton && importOverlay && importFile) {
                importButton.addEventListener('click', function () {
                    importFile.value = '';
                    openOverlay(importOverlay, importFile);
                });
            }

            document.querySelectorAll('.js-geolistrik-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    readNama.textContent = button.dataset.kode ? 'Detail Geolistrik 1D - ' + button.dataset.kode : 'Detail Geolistrik 1D';
                    readKode.textContent = button.dataset.kode || '-';
                    readKabKota.textContent = button.dataset.kabKota || '-';
                    readKecamatan.textContent = button.dataset.kecamatan || '-';
                    readDesaKelurahan.textContent = button.dataset.desaKelurahan || '-';
                    readUpt.textContent = button.dataset.upt || '-';
                    readLatitude.textContent = button.dataset.latitude || '-';
                    readLongitude.textContent = button.dataset.longitude || '-';
                    readElevasi.textContent = button.dataset.elevasi || '-';
                    readTanggalAkusisiData.textContent = button.dataset.tanggalAkusisiData || '-';
                    readGeologi.textContent = button.dataset.geologi || '-';
                    readCekunganAirTanah.textContent = button.dataset.cekunganAirTanah || '-';
                    readHidrogeologi.textContent = button.dataset.hidrogeologi || '-';
                    readLapisanPembawaAir.textContent = button.dataset.lapisanPembawaAir || '-';
                    if (readPdf) {
                        if (button.dataset.pdfUrl) {
                            readPdf.innerHTML = '<a href="' + button.dataset.pdfUrl + '" target="_blank" rel="noopener">' + (button.dataset.pdfName || 'PDF') + '</a>';
                        } else {
                            readPdf.textContent = '-';
                        }
                    }
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-geolistrik-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    updateForm.action = button.dataset.updateUrl || '';
                    updateKode.value = button.dataset.kode || '';
                    updateKabKota.value = button.dataset.kabKota || '';
                    updateKecamatan.value = button.dataset.kecamatan || '';
                    updateDesaKelurahan.value = button.dataset.desaKelurahan || '';
                    updateUpt.value = button.dataset.upt || '';
                    updateLatitude.value = button.dataset.latitude || '';
                    updateLongitude.value = button.dataset.longitude || '';
                    updateElevasi.value = button.dataset.elevasi || '';
                    updateTanggalAkusisiData.value = button.dataset.tanggalAkusisiData || '';
                    updateGeologi.value = button.dataset.geologi || '';
                    updateCekunganAirTanah.value = button.dataset.cekunganAirTanah || '';
                    updateHidrogeologi.value = button.dataset.hidrogeologi || '';
                    updateLapisanPembawaAir.value = button.dataset.lapisanPembawaAir || '';
                    if (updatePdfFile) updatePdfFile.value = '';
                    if (updatePdfCurrent) {
                        if (button.dataset.pdfUrl) {
                            updatePdfCurrent.innerHTML = '<a href="' + button.dataset.pdfUrl + '" target="_blank" rel="noopener">' + (button.dataset.pdfName || 'PDF') + '</a>';
                        } else {
                            updatePdfCurrent.textContent = '-';
                        }
                    }
                    openOverlay(updateOverlay, updateKode);
                });
            });

            document.querySelectorAll('.js-geolistrik-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus data Geolistrik 1D ini?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeOverlay(overlay);
                    }
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllOverlays();
                }
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createKode);
            }

            if (document.body.dataset.openImportPreview === 'true' && importPreviewOverlay) {
                openOverlay(importPreviewOverlay);
            }
        })();

/* =========================================================
   resources/views/pages/admin/berita.blade.php
   ========================================================= */
(function () {
            const createOpenButton = document.getElementById('openBeritaPopup');
            const createOverlay = document.getElementById('beritaPopupOverlay');
            const createInput = document.getElementById('beritaPopupInput');
            const readOverlay = document.getElementById('readBeritaOverlay');
            const updateOverlay = document.getElementById('updateBeritaOverlay');
            const readTitle = document.getElementById('readBeritaTitle');
            const readCreated = document.getElementById('readBeritaCreated');
            const readDescription = document.getElementById('readBeritaDescription');
            const readImages = document.getElementById('readBeritaImages');
            const updateForm = document.getElementById('updateBeritaForm');
            const updateId = document.getElementById('updateBeritaId');
            const updateJudul = document.getElementById('updateBeritaJudul');
            const updateDeskripsi = document.getElementById('updateBeritaDeskripsi');
            const existingImageList = document.getElementById('existingImageList');

            if (!createOpenButton || !createOverlay || !createInput) return;

            const itemLabel = createOpenButton.dataset.itemLabel || 'Berita';
            const itemLabelLower = itemLabel.toLowerCase();

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            function parseImages(raw) {
                if (!raw) return [];
                try {
                    const parsed = JSON.parse(raw);
                    return Array.isArray(parsed) ? parsed : [];
                } catch (error) {
                    return [];
                }
            }

            function createImagePicker(options) {
                const inputList = document.getElementById(options.inputListId);
                const addButton = document.getElementById(options.addButtonId);
                const previewList = document.getElementById(options.previewListId);
                const minOne = options.minOne === true;
                const requireFirst = options.requireFirst === true;

                if (!inputList || !addButton || !previewList) {
                    return {
                        reset: function () {}
                    };
                }

                function updateRemoveButtonState() {
                    const rows = inputList.querySelectorAll('.image-input-row');
                    rows.forEach(function (row) {
                        const removeButton = row.querySelector('.btn-remove-image-input');
                        if (!removeButton) return;
                        removeButton.disabled = minOne && rows.length <= 1;
                    });
                }

                function renderPreview() {
                    previewList.innerHTML = '';
                    const files = [];

                    inputList.querySelectorAll('input[type="file"]').forEach(function (input) {
                        if (input.files && input.files[0]) {
                            files.push(input.files[0]);
                        }
                    });

                    if (!files.length) {
                        previewList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar dipilih.</p>';
                        return;
                    }

                    files.forEach(function (file, index) {
                        const item = document.createElement('div');
                        item.className = 'upload-preview-item';
                        const imageUrl = URL.createObjectURL(file);
                        item.innerHTML = '<img src="' + imageUrl + '" alt="Preview ' + (index + 1) + '">';
                        const img = item.querySelector('img');
                        if (img) {
                            img.addEventListener('load', function () {
                                URL.revokeObjectURL(imageUrl);
                            });
                        }
                        previewList.appendChild(item);
                    });
                }

                function addRow(isRequired) {
                    const row = document.createElement('div');
                    row.className = 'image-input-row';
                    row.innerHTML =
                        '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*"' + (isRequired ? ' required' : '') + '>' +
                        '<button type="button" class="btn-remove-image-input">Hapus</button>';

                    const input = row.querySelector('input[type="file"]');
                    const removeButton = row.querySelector('.btn-remove-image-input');

                    if (input) {
                        input.addEventListener('change', renderPreview);
                    }

                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            row.remove();
                            if (minOne && !inputList.querySelector('.image-input-row')) {
                                addRow(requireFirst);
                            }
                            updateRemoveButtonState();
                            renderPreview();
                        });
                    }

                    inputList.appendChild(row);
                    updateRemoveButtonState();
                    renderPreview();
                }

                addButton.addEventListener('click', function () {
                    addRow(false);
                });

                function reset() {
                    inputList.innerHTML = '';
                    addRow(requireFirst);
                }

                reset();

                return {
                    reset: reset
                };
            }

            const createImagePickerController = createImagePicker({
                inputListId: 'createImageInputList',
                addButtonId: 'addCreateImageInput',
                previewListId: 'createUploadPreviewList',
                minOne: true,
                requireFirst: false
            });

            const updateImagePickerController = createImagePicker({
                inputListId: 'updateImageInputList',
                addButtonId: 'addUpdateImageInput',
                previewListId: 'updateUploadPreviewList',
                minOne: true,
                requireFirst: false
            });

            createOpenButton.addEventListener('click', function () {
                createImagePickerController.reset();
                openOverlay(createOverlay, createInput);
            });

            // --- Video preview helpers ---
            function setupVideoPreview(inputId, previewId, videoElId, clearBtnId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const videoEl = document.getElementById(videoElId);
                const clearBtn = document.getElementById(clearBtnId);
                if (!input || !preview || !videoEl) return;
                input.addEventListener('change', function () {
                    const file = input.files && input.files[0];
                    if (file) {
                        videoEl.src = URL.createObjectURL(file);
                        preview.style.display = '';
                    } else {
                        preview.style.display = 'none';
                        videoEl.src = '';
                    }
                });
                if (clearBtn) {
                    clearBtn.addEventListener('click', function () {
                        input.value = '';
                        videoEl.src = '';
                        preview.style.display = 'none';
                    });
                }
            }
            setupVideoPreview('createVideoInput', 'createVideoPreview', 'createVideoEl', 'clearCreateVideo');
            setupVideoPreview('updateVideoInput', 'updateVideoPreview', 'updateVideoEl', 'clearUpdateVideo');

            // --- Read popup ---
            const readVideoWrap = document.getElementById('readBeritaVideo');
            const readVideoEl = document.getElementById('readBeritaVideoEl');

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    readTitle.textContent = button.dataset.judul || ('Detail ' + itemLabel);
                    readCreated.textContent = 'Tanggal dibuat: ' + (button.dataset.created || '-');
                    readDescription.textContent = button.dataset.deskripsi || '-';

                    // Video
                    const videoUrl = button.dataset.videoUrl || '';
                    if (readVideoWrap && readVideoEl) {
                        if (videoUrl) {
                            readVideoEl.src = videoUrl;
                            readVideoWrap.style.display = '';
                        } else {
                            readVideoEl.src = '';
                            readVideoWrap.style.display = 'none';
                        }
                    }

                    readImages.innerHTML = '';
                    if (!images.length) {
                        readImages.innerHTML = '<p class="read-meta empty-cell-message">Tidak ada gambar.</p>';
                    } else {
                        images.forEach(function (image) {
                            const img = document.createElement('img');
                            img.src = image.url;
                            img.alt = button.dataset.judul || ('Gambar ' + itemLabelLower);
                            readImages.appendChild(img);
                        });
                    }

                    openOverlay(readOverlay);
                });
            });

            // --- Update popup ---
            const existingVideoBlock = document.getElementById('existingVideoBlock');
            const existingVideoEl = document.getElementById('existingVideoEl');
            const removeVideoCheckbox = document.getElementById('removeVideoCheckbox');
            const updateVideoOrientasi = document.getElementById('updateVideoOrientasi');
            const newVideoLabel = document.getElementById('newVideoLabel');

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    updateForm.action = button.dataset.updateUrl || '';
                    updateId.value = button.dataset.id || '';
                    updateJudul.value = button.dataset.judul || '';
                    updateDeskripsi.value = button.dataset.deskripsi || '';
                    updateImagePickerController.reset();

                    // Existing video
                    const videoUrl = button.dataset.videoUrl || '';
                    const videoOrientasi = button.dataset.videoOrientasi || 'landscape';
                    if (existingVideoBlock && existingVideoEl) {
                        if (videoUrl) {
                            existingVideoEl.src = videoUrl;
                            existingVideoBlock.style.display = '';
                            if (newVideoLabel) newVideoLabel.textContent = 'Ganti dengan Video Baru (Opsional)';
                        } else {
                            existingVideoEl.src = '';
                            existingVideoBlock.style.display = 'none';
                            if (newVideoLabel) newVideoLabel.textContent = 'Unggah Video Baru (Opsional)';
                        }
                        if (removeVideoCheckbox) removeVideoCheckbox.checked = false;
                    }
                    if (updateVideoOrientasi) updateVideoOrientasi.value = videoOrientasi;

                    existingImageList.innerHTML = '';
                    if (images.length) {
                        images.forEach(function (image, index) {
                            const item = document.createElement('div');
                            item.className = 'existing-image-item';
                            item.innerHTML =
                                '<img src="' + image.url + '" alt="Gambar ' + (index + 1) + '">' +
                                '<label><input type="checkbox" name="remove_image_ids[]" value="' + image.id + '"> Hapus gambar</label>';
                            existingImageList.appendChild(item);
                        });
                    } else {
                        existingImageList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar.</p>';
                    }

                    openOverlay(updateOverlay, updateJudul);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus ' + itemLabelLower + ' ini beserta semua gambarnya?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeOverlay(overlay);
                    }
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllOverlays();
                }
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createInput);
            }
        })();

/* =========================================================
   resources/views/pages/admin/gems.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createTitleInput = document.getElementById('createTitleInput');
            const readOverlay = document.getElementById('readOverlay');
            const updateOverlay = document.getElementById('updateOverlay');
            const readTitle = document.getElementById('readTitle');
            const readImages = document.getElementById('readImages');
            const updateForm = document.getElementById('updateForm');
            const updateId = document.getElementById('updateGemId');
            const updateTitleInput = document.getElementById('updateTitleInput');
            const existingImageList = document.getElementById('existingImageList');
            if (!openButton || !createOverlay || !createTitleInput) return;

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            function parseImages(raw) {
                if (!raw) return [];
                try {
                    const parsed = JSON.parse(raw);
                    return Array.isArray(parsed) ? parsed : [];
                } catch (error) {
                    return [];
                }
            }

            function createImagePicker(options) {
                const inputList = document.getElementById(options.inputListId);
                const addButton = document.getElementById(options.addButtonId);
                const previewList = document.getElementById(options.previewListId);
                const minOne = options.minOne === true;
                const requireFirst = options.requireFirst === true;

                if (!inputList || !addButton || !previewList) {
                    return { reset: function () {} };
                }

                function updateRemoveButtonState() {
                    const rows = inputList.querySelectorAll('.image-input-row');
                    rows.forEach(function (row) {
                        const removeButton = row.querySelector('.btn-remove-image-input');
                        if (!removeButton) return;
                        removeButton.disabled = minOne && rows.length <= 1;
                    });
                }

                function renderPreview() {
                    previewList.innerHTML = '';
                    const files = [];
                    inputList.querySelectorAll('input[type="file"]').forEach(function (input) {
                        if (input.files && input.files.length) {
                            Array.from(input.files).forEach(function (file) {
                                files.push(file);
                            });
                        }
                    });
                    if (!files.length) {
                        previewList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar dipilih.</p>';
                        return;
                    }
                    files.forEach(function (file, index) {
                        const item = document.createElement('div');
                        item.className = 'upload-preview-item';
                        const imageUrl = URL.createObjectURL(file);
                        item.innerHTML = '<img src="' + imageUrl + '" alt="Preview ' + (index + 1) + '">';
                        const img = item.querySelector('img');
                        if (img) {
                            img.addEventListener('load', function () {
                                URL.revokeObjectURL(imageUrl);
                            });
                        }
                        previewList.appendChild(item);
                    });
                }

                function addRow(isRequired) {
                    const row = document.createElement('div');
                    row.className = 'image-input-row';
                    row.innerHTML =
                        '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*" multiple' + (isRequired ? ' required' : '') + '>' +
                        '<button type="button" class="btn-remove-image-input">Hapus</button>';

                    const input = row.querySelector('input[type="file"]');
                    const removeButton = row.querySelector('.btn-remove-image-input');

                    if (input) {
                        input.addEventListener('change', renderPreview);
                    }

                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            row.remove();
                            if (minOne && !inputList.querySelector('.image-input-row')) {
                                addRow(requireFirst);
                            }
                            updateRemoveButtonState();
                            renderPreview();
                        });
                    }

                    inputList.appendChild(row);
                    updateRemoveButtonState();
                    renderPreview();
                }

                addButton.addEventListener('click', function () {
                    addRow(false);
                });

                function reset() {
                    inputList.innerHTML = '';
                    addRow(requireFirst);
                }

                reset();
                return { reset: reset };
            }

            const createImagePickerController = createImagePicker({
                inputListId: 'createImageInputList',
                addButtonId: 'addCreateImageInput',
                previewListId: 'createUploadPreviewList',
                minOne: true,
                requireFirst: true
            });

            const updateImagePickerController = createImagePicker({
                inputListId: 'updateImageInputList',
                addButtonId: 'addUpdateImageInput',
                previewListId: 'updateUploadPreviewList',
                minOne: false,
                requireFirst: false
            });

            openButton.addEventListener('click', function () {
                createTitleInput.value = '';
                createImagePickerController.reset();
                openOverlay(createOverlay, createTitleInput);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    readTitle.textContent = button.dataset.judul || 'Detail GEMS';
                    readImages.innerHTML = '';
                    if (!images.length) {
                        readImages.innerHTML = '<p class="read-meta empty-cell-message">Tidak ada gambar.</p>';
                    } else {
                        images.forEach(function (image) {
                            const img = document.createElement('img');
                            img.src = image.url;
                            img.alt = button.dataset.judul || 'GEMS';
                            readImages.appendChild(img);
                        });
                    }
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    updateForm.action = button.dataset.updateUrl || '';
                    updateId.value = button.dataset.id || '';
                    updateTitleInput.value = button.dataset.judul || '';
                    updateImagePickerController.reset();

                    existingImageList.innerHTML = '';
                    if (images.length) {
                        images.forEach(function (image, index) {
                            const item = document.createElement('div');
                            item.className = 'existing-image-item';
                            item.innerHTML =
                                '<img src="' + image.url + '" alt="Gambar ' + (index + 1) + '">' +
                                '<label><input type="checkbox" name="remove_image_ids[]" value="' + image.id + '"> Hapus gambar</label>';
                            existingImageList.appendChild(item);
                        });
                    } else {
                        existingImageList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar.</p>';
                    }

                    openOverlay(updateOverlay, updateTitleInput);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus data GEMS ini beserta semua gambarnya?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) closeOverlay(overlay);
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeAllOverlays();
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createTitleInput);
            }
        })();

/* =========================================================
   resources/views/pages/admin/karya-ilmiah.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openKaryaPopup');
            const createOverlay = document.getElementById('createKaryaOverlay');
            const createJudul = document.getElementById('createKaryaJudul');
            const readOverlay = document.getElementById('readKaryaOverlay');
            const readTitle = document.getElementById('readKaryaTitle');
            const readThumb = document.getElementById('readKaryaThumb');
            const readDesc = document.getElementById('readKaryaDesc');
            const readPdf = document.getElementById('readKaryaPdf');
            const updateOverlay = document.getElementById('updateKaryaOverlay');
            const updateForm = document.getElementById('updateKaryaForm');
            const updateJudul = document.getElementById('updateKaryaJudul');
            const updateDesc = document.getElementById('updateKaryaDeskripsi');
            const updateCurrentThumb = document.getElementById('updateKaryaCurrentThumb');
            const updateCurrentPdf = document.getElementById('updateKaryaCurrentPdf');

            if (!openButton || !createOverlay) return;

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            openButton.addEventListener('click', function () {
                openOverlay(createOverlay, createJudul);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    readTitle.textContent = button.dataset.judul || 'Detail Karya Ilmiah';
                    readThumb.innerHTML = button.dataset.thumbnailUrl
                        ? '<img src="' + button.dataset.thumbnailUrl + '" alt="Thumbnail karya ilmiah">'
                        : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>';
                    readDesc.textContent = button.dataset.deskripsi || '-';
                    readPdf.textContent = button.dataset.pdfName || '-';
                    readPdf.href = button.dataset.pdfUrl || '#';
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    updateForm.action = button.dataset.updateUrl || '';
                    updateJudul.value = button.dataset.judul || '';
                    updateDesc.value = button.dataset.deskripsi || '';
                    updateCurrentThumb.innerHTML = button.dataset.thumbnailUrl
                        ? '<img src="' + button.dataset.thumbnailUrl + '" alt="Thumbnail saat ini">'
                        : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>';
                    updateCurrentPdf.textContent = button.dataset.pdfName || '-';
                    updateCurrentPdf.href = button.dataset.pdfUrl || '#';
                    openOverlay(updateOverlay, updateJudul);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus karya ilmiah ini?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeOverlay(overlay);
                    }
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllOverlays();
                }
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createJudul);
            }
        })();

/* =========================================================
   resources/views/pages/admin/laporan-skm.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openItemPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createJudul = document.getElementById('createJudul');
            const readOverlay = document.getElementById('readOverlay');
            const readTitle = document.getElementById('readTitle');
            const readThumb = document.getElementById('readThumb');
            const readDesc = document.getElementById('readDesc');
            const readPdf = document.getElementById('readPdf');
            const updateOverlay = document.getElementById('updateOverlay');
            const updateForm = document.getElementById('updateForm');
            const updateJudul = document.getElementById('updateJudul');
            const updateDeskripsi = document.getElementById('updateDeskripsi');
            const updateCurrentThumb = document.getElementById('updateCurrentThumb');
            const updateCurrentPdf = document.getElementById('updateCurrentPdf');
            if (!openButton || !createOverlay) return;
            function openOverlay(el, focusTarget){ if(!el) return; el.classList.add('is-open'); el.setAttribute('aria-hidden','false'); if(focusTarget){ setTimeout(function(){focusTarget.focus();},0);} }
            function closeOverlay(el){ if(!el) return; el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); }
            function closeAll(){ document.querySelectorAll('.popup-overlay.is-open').forEach(function(el){ closeOverlay(el); }); }
            openButton.addEventListener('click', function(){ openOverlay(createOverlay, createJudul); });
            document.querySelectorAll('.js-read-btn').forEach(function(btn){ btn.addEventListener('click', function(){ readTitle.textContent = btn.dataset.judul || 'Detail Laporan SKM'; readThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail">' : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>'; readDesc.textContent = btn.dataset.deskripsi || '-'; readPdf.textContent = btn.dataset.pdfName || '-'; readPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(readOverlay); }); });
            document.querySelectorAll('.js-update-btn').forEach(function(btn){ btn.addEventListener('click', function(){ updateForm.action = btn.dataset.updateUrl || ''; updateJudul.value = btn.dataset.judul || ''; updateDeskripsi.value = btn.dataset.deskripsi || ''; updateCurrentThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail saat ini">' : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>'; updateCurrentPdf.textContent = btn.dataset.pdfName || '-'; updateCurrentPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(updateOverlay, updateJudul); }); });
            document.querySelectorAll('.js-delete-form').forEach(function(form){ form.addEventListener('submit', function(e){ if(!window.confirm('Hapus laporan SKM ini?')) e.preventDefault(); }); });
            document.querySelectorAll('.popup-overlay').forEach(function(overlay){ overlay.addEventListener('click', function(e){ if(e.target===overlay) closeOverlay(overlay); }); });
            document.querySelectorAll('[data-close-overlay]').forEach(function(btn){ btn.addEventListener('click', function(){ const id = btn.getAttribute('data-close-overlay'); if(id) closeOverlay(document.getElementById(id)); }); });
            document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeAll(); });
            if (document.body.dataset.openCreatePopup === 'true') { openOverlay(createOverlay, createJudul); }
        })();

/* =========================================================
   resources/views/pages/admin/pengumuman.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openPopup');
            const createOverlay = document.getElementById('createOverlay');
            const readOverlay = document.getElementById('readOverlay');
            const updateOverlay = document.getElementById('updateOverlay');
            const createInput = document.getElementById('createInput');
            const createPreview = document.getElementById('createPreview');
            const readImage = document.getElementById('readImage');
            const updateForm = document.getElementById('updateForm');
            const currentPreview = document.getElementById('currentPreview');
            const updateInput = document.getElementById('updateInput');
            const updatePreview = document.getElementById('updatePreview');
            if (!openButton || !createOverlay || !readOverlay || !updateOverlay) return;

            function openOverlay(el, focusTarget){ el.classList.add('is-open'); el.setAttribute('aria-hidden','false'); if(focusTarget){ setTimeout(function(){ focusTarget.focus(); },0);} }
            function closeOverlay(el){ el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); }
            function closeAllOverlays(){ document.querySelectorAll('.popup-overlay.is-open').forEach(function(el){ closeOverlay(el); }); }
            function renderPreview(container, file, fallbackUrl){
                if (!container) return;
                container.innerHTML = '';
                if (file) {
                    const url = URL.createObjectURL(file);
                    container.innerHTML = '<img src="' + url + '" alt="Preview">';
                    const img = container.querySelector('img');
                    if (img) img.addEventListener('load', function () { URL.revokeObjectURL(url); });
                    return;
                }
                if (fallbackUrl) container.innerHTML = '<img src="' + fallbackUrl + '" alt="Gambar">';
            }

            openButton.addEventListener('click', function () {
                createInput.value = '';
                renderPreview(createPreview, null, null);
                openOverlay(createOverlay, createInput);
            });

            createInput.addEventListener('change', function () {
                const file = createInput.files && createInput.files[0] ? createInput.files[0] : null;
                renderPreview(createPreview, file, null);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    readImage.innerHTML = '<img src="' + (btn.dataset.image || '') + '" alt="Detail pengumuman">';
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    updateForm.action = btn.dataset.updateUrl || '';
                    updateInput.value = '';
                    renderPreview(currentPreview, null, btn.dataset.image || null);
                    renderPreview(updatePreview, null, null);
                    openOverlay(updateOverlay, updateInput);
                });
            });

            updateInput.addEventListener('change', function () {
                const file = updateInput.files && updateInput.files[0] ? updateInput.files[0] : null;
                renderPreview(updatePreview, file, null);
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus pengumuman ini?')) event.preventDefault();
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) closeOverlay(overlay);
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    const overlay = document.getElementById(overlayId);
                    if (overlay) closeOverlay(overlay);
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeAllOverlays();
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createInput);
            }
        })();

/* =========================================================
   resources/views/pages/admin/siatab.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createTitleInput = document.getElementById('createTitleInput');
            const readOverlay = document.getElementById('readOverlay');
            const updateOverlay = document.getElementById('updateOverlay');
            const readTitle = document.getElementById('readTitle');
            const readImages = document.getElementById('readImages');
            const updateForm = document.getElementById('updateForm');
            const updateId = document.getElementById('updateSiatabId');
            const updateTitleInput = document.getElementById('updateTitleInput');
            const existingImageList = document.getElementById('existingImageList');
            if (!openButton || !createOverlay || !createTitleInput) return;

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            function parseImages(raw) {
                if (!raw) return [];
                try {
                    const parsed = JSON.parse(raw);
                    return Array.isArray(parsed) ? parsed : [];
                } catch (error) {
                    return [];
                }
            }

            function createImagePicker(options) {
                const inputList = document.getElementById(options.inputListId);
                const addButton = document.getElementById(options.addButtonId);
                const previewList = document.getElementById(options.previewListId);
                const minOne = options.minOne === true;
                const requireFirst = options.requireFirst === true;

                if (!inputList || !addButton || !previewList) {
                    return { reset: function () {} };
                }

                function updateRemoveButtonState() {
                    const rows = inputList.querySelectorAll('.image-input-row');
                    rows.forEach(function (row) {
                        const removeButton = row.querySelector('.btn-remove-image-input');
                        if (!removeButton) return;
                        removeButton.disabled = minOne && rows.length <= 1;
                    });
                }

                function renderPreview() {
                    previewList.innerHTML = '';
                    const files = [];
                    inputList.querySelectorAll('input[type="file"]').forEach(function (input) {
                        if (input.files && input.files.length) {
                            Array.from(input.files).forEach(function (file) {
                                files.push(file);
                            });
                        }
                    });
                    if (!files.length) {
                        previewList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar dipilih.</p>';
                        return;
                    }
                    files.forEach(function (file, index) {
                        const item = document.createElement('div');
                        item.className = 'upload-preview-item';
                        const imageUrl = URL.createObjectURL(file);
                        item.innerHTML = '<img src="' + imageUrl + '" alt="Preview ' + (index + 1) + '">';
                        const img = item.querySelector('img');
                        if (img) {
                            img.addEventListener('load', function () {
                                URL.revokeObjectURL(imageUrl);
                            });
                        }
                        previewList.appendChild(item);
                    });
                }

                function addRow(isRequired) {
                    const row = document.createElement('div');
                    row.className = 'image-input-row';
                    row.innerHTML =
                        '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*" multiple' + (isRequired ? ' required' : '') + '>' +
                        '<button type="button" class="btn-remove-image-input">Hapus</button>';

                    const input = row.querySelector('input[type="file"]');
                    const removeButton = row.querySelector('.btn-remove-image-input');

                    if (input) {
                        input.addEventListener('change', renderPreview);
                    }

                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            row.remove();
                            if (minOne && !inputList.querySelector('.image-input-row')) {
                                addRow(requireFirst);
                            }
                            updateRemoveButtonState();
                            renderPreview();
                        });
                    }

                    inputList.appendChild(row);
                    updateRemoveButtonState();
                    renderPreview();
                }

                addButton.addEventListener('click', function () {
                    addRow(false);
                });

                function reset() {
                    inputList.innerHTML = '';
                    addRow(requireFirst);
                }

                reset();
                return { reset: reset };
            }

            const createImagePickerController = createImagePicker({
                inputListId: 'createImageInputList',
                addButtonId: 'addCreateImageInput',
                previewListId: 'createUploadPreviewList',
                minOne: true,
                requireFirst: true
            });

            const updateImagePickerController = createImagePicker({
                inputListId: 'updateImageInputList',
                addButtonId: 'addUpdateImageInput',
                previewListId: 'updateUploadPreviewList',
                minOne: false,
                requireFirst: false
            });

            openButton.addEventListener('click', function () {
                createTitleInput.value = '';
                createImagePickerController.reset();
                openOverlay(createOverlay, createTitleInput);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    readTitle.textContent = button.dataset.judul || 'Detail SIATAB';
                    readImages.innerHTML = '';
                    if (!images.length) {
                        readImages.innerHTML = '<p class="read-meta empty-cell-message">Tidak ada gambar.</p>';
                    } else {
                        images.forEach(function (image) {
                            const img = document.createElement('img');
                            img.src = image.url;
                            img.alt = button.dataset.judul || 'SIATAB';
                            readImages.appendChild(img);
                        });
                    }
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    updateForm.action = button.dataset.updateUrl || '';
                    updateId.value = button.dataset.id || '';
                    updateTitleInput.value = button.dataset.judul || '';
                    updateImagePickerController.reset();

                    existingImageList.innerHTML = '';
                    if (images.length) {
                        images.forEach(function (image, index) {
                            const item = document.createElement('div');
                            item.className = 'existing-image-item';
                            item.innerHTML =
                                '<img src="' + image.url + '" alt="Gambar ' + (index + 1) + '">' +
                                '<label><input type="checkbox" name="remove_image_ids[]" value="' + image.id + '"> Hapus gambar</label>';
                            existingImageList.appendChild(item);
                        });
                    } else {
                        existingImageList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar.</p>';
                    }

                    openOverlay(updateOverlay, updateTitleInput);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus data SIATAB ini beserta semua gambarnya?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) closeOverlay(overlay);
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closeAllOverlays();
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createTitleInput);
            }
        })();

/* =========================================================
   resources/views/pages/admin/sni.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openItemPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createJudul = document.getElementById('createJudul');
            const readOverlay = document.getElementById('readOverlay');
            const readTitle = document.getElementById('readTitle');
            const readThumb = document.getElementById('readThumb');
            const readDesc = document.getElementById('readDesc');
            const readPdf = document.getElementById('readPdf');
            const updateOverlay = document.getElementById('updateOverlay');
            const updateForm = document.getElementById('updateForm');
            const updateJudul = document.getElementById('updateJudul');
            const updateDeskripsi = document.getElementById('updateDeskripsi');
            const updateCurrentThumb = document.getElementById('updateCurrentThumb');
            const updateCurrentPdf = document.getElementById('updateCurrentPdf');
            if (!openButton || !createOverlay) return;
            function openOverlay(el, focusTarget){ if(!el) return; el.classList.add('is-open'); el.setAttribute('aria-hidden','false'); if(focusTarget){ setTimeout(function(){focusTarget.focus();},0);} }
            function closeOverlay(el){ if(!el) return; el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); }
            function closeAll(){ document.querySelectorAll('.popup-overlay.is-open').forEach(function(el){ closeOverlay(el); }); }
            openButton.addEventListener('click', function(){ openOverlay(createOverlay, createJudul); });
            document.querySelectorAll('.js-read-btn').forEach(function(btn){ btn.addEventListener('click', function(){ readTitle.textContent = btn.dataset.judul || 'Detail SNI'; readThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail">' : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>'; readDesc.textContent = btn.dataset.deskripsi || '-'; readPdf.textContent = btn.dataset.pdfName || '-'; readPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(readOverlay); }); });
            document.querySelectorAll('.js-update-btn').forEach(function(btn){ btn.addEventListener('click', function(){ updateForm.action = btn.dataset.updateUrl || ''; updateJudul.value = btn.dataset.judul || ''; updateDeskripsi.value = btn.dataset.deskripsi || ''; updateCurrentThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail saat ini">' : '<p class="read-meta thumb-empty">Thumbnail belum tersedia.</p>'; updateCurrentPdf.textContent = btn.dataset.pdfName || '-'; updateCurrentPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(updateOverlay, updateJudul); }); });
            document.querySelectorAll('.js-delete-form').forEach(function(form){ form.addEventListener('submit', function(e){ if(!window.confirm('Hapus data SNI ini?')) e.preventDefault(); }); });
            document.querySelectorAll('.popup-overlay').forEach(function(overlay){ overlay.addEventListener('click', function(e){ if(e.target===overlay) closeOverlay(overlay); }); });
            document.querySelectorAll('[data-close-overlay]').forEach(function(btn){ btn.addEventListener('click', function(){ const id = btn.getAttribute('data-close-overlay'); if(id) closeOverlay(document.getElementById(id)); }); });
            document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeAll(); });
            if (document.body.dataset.openCreatePopup === 'true') { openOverlay(createOverlay, createJudul); }
        })();

/* =========================================================
   resources/views/pages/admin/thumbnail.blade.php
   ========================================================= */
(function () {
            const openButton = document.getElementById('openThumbnailPopup');
            const createOverlay = document.getElementById('createThumbnailOverlay');
            const readOverlay = document.getElementById('readThumbnailOverlay');
            const updateOverlay = document.getElementById('updateThumbnailOverlay');
            const createInput = document.getElementById('createThumbnailInput');
            const createPreview = document.getElementById('createThumbnailPreview');
            const createTitleInput = document.getElementById('createTitleInput');
            const readImage = document.getElementById('readThumbnailImage');
            const readTitleText = document.getElementById('readThumbnailTitleText');
            const readDescription = document.getElementById('readThumbnailDescription');
            const updateForm = document.getElementById('updateThumbnailForm');
            const currentPreview = document.getElementById('currentThumbnailPreview');
            const updateInput = document.getElementById('updateThumbnailInput');
            const updatePreview = document.getElementById('updateThumbnailPreview');
            const updateTitleInput = document.getElementById('updateTitleInput');
            const createDescriptionInput = document.getElementById('createDescriptionInput');
            const updateDescriptionInput = document.getElementById('updateDescriptionInput');
            const visibilityForm = document.getElementById('thumbnailVisibilityForm');

            if (!openButton || !createOverlay || !readOverlay || !updateOverlay) return;

            function openOverlay(overlay, focusTarget) {
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            function renderPreview(container, file, fallbackUrl) {
                if (!container) return;
                container.innerHTML = '';

                if (file) {
                    const url = URL.createObjectURL(file);
                    container.innerHTML = '<img src="' + url + '" alt="Preview thumbnail">';
                    const img = container.querySelector('img');
                    if (img) {
                        img.addEventListener('load', function () {
                            URL.revokeObjectURL(url);
                        });
                    }
                    return;
                }

                if (fallbackUrl) {
                    container.innerHTML = '<img src="' + fallbackUrl + '" alt="Thumbnail">';
                } else {
                    container.innerHTML = '<p class="read-meta thumb-empty">Belum ada gambar.</p>';
                }
            }

            openButton.addEventListener('click', function () {
                if (createInput) createInput.value = '';
                if (createTitleInput) createTitleInput.value = '';
                if (createDescriptionInput) createDescriptionInput.value = '';
                renderPreview(createPreview, null, null);
                openOverlay(createOverlay, createInput);
            });

            if (createInput) {
                createInput.addEventListener('change', function () {
                    const file = createInput.files && createInput.files[0] ? createInput.files[0] : null;
                    renderPreview(createPreview, file, null);
                });
            }

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    readImage.innerHTML = '<img src="' + (button.dataset.image || '') + '" alt="Detail thumbnail">';
                    if (readTitleText) {
                        readTitleText.textContent = button.dataset.title || '-';
                    }
                    if (readDescription) {
                        readDescription.textContent = button.dataset.description || '-';
                    }
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (updateForm) {
                        updateForm.action = button.dataset.updateUrl || '';
                    }
                    if (updateInput) {
                        updateInput.value = '';
                    }
                    if (updateTitleInput) {
                        updateTitleInput.value = button.dataset.title || '';
                    }
                    if (updateDescriptionInput) {
                        updateDescriptionInput.value = button.dataset.description || '';
                    }
                    renderPreview(currentPreview, null, button.dataset.image || null);
                    renderPreview(updatePreview, null, null);
                    openOverlay(updateOverlay, updateInput);
                });
            });

            if (updateInput) {
                updateInput.addEventListener('change', function () {
                    const file = updateInput.files && updateInput.files[0] ? updateInput.files[0] : null;
                    renderPreview(updatePreview, file, null);
                });
            }

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus thumbnail ini?')) {
                        event.preventDefault();
                    }
                });
            });

            if (visibilityForm) {
                visibilityForm.addEventListener('submit', function () {
                    visibilityForm.querySelectorAll('input[name="selected_thumbnail_ids[]"]').forEach(function (input) {
                        input.remove();
                    });

                    const selectedIds = [];
                    document.querySelectorAll('.js-thumbnail-visible:checked').forEach(function (checkbox) {
                        selectedIds.push(checkbox.value);
                    });

                    selectedIds.forEach(function (id) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_thumbnail_ids[]';
                        input.value = id;
                        visibilityForm.appendChild(input);
                    });
                });
            }

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeOverlay(overlay);
                    }
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    const overlay = document.getElementById(overlayId);
                    if (overlay) closeOverlay(overlay);
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllOverlays();
                }
            });

            if (document.body.dataset.openCreatePopup === 'true') {
                openOverlay(createOverlay, createInput);
            }
        })();

/* =========================================================
   resources/views/pages/admin/buletin.blade.php
   ========================================================= */
(function () {
    const createOpenButton = document.getElementById('openBuletinPopup');
    const createOverlay = document.getElementById('buletinPopupOverlay');
    const createInput = document.getElementById('buletinPopupInput');
    const readOverlay = document.getElementById('readBuletinOverlay');
    const updateOverlay = document.getElementById('updateBuletinOverlay');
    const readTitle = document.getElementById('readBuletinTitle');
    const readMeta = document.getElementById('readBuletinMeta');
    const readIsi = document.getElementById('readBuletinIsi');
    const readImages = document.getElementById('readBuletinImages');
    const updateForm = document.getElementById('updateBuletinForm');
    const updateId = document.getElementById('updateBuletinId');
    const updateJudul = document.getElementById('updateBuletinJudul');
    const updateIsi = document.getElementById('updateBuletinIsi');
    const updateStatus = document.getElementById('updateBuletinStatus');
    const updatePublishedAt = document.getElementById('updateBuletinPublishedAt');
    const existingImageList = document.getElementById('existingBuletinImageList');

    if (!createOpenButton || !createOverlay || !createInput) return;

    function openOverlay(overlay, focusTarget) {
        if (!overlay) return;
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        if (focusTarget) {
            window.setTimeout(function () {
                focusTarget.focus();
            }, 0);
        }
    }

    function closeOverlay(overlay) {
        if (!overlay) return;
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    function closeAllOverlays() {
        document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
            closeOverlay(overlay);
        });
    }

    function parseImages(raw) {
        if (!raw) return [];
        try {
            const parsed = JSON.parse(raw);
            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            return [];
        }
    }

    function createImagePicker(options) {
        const inputList = document.getElementById(options.inputListId);
        const addButton = document.getElementById(options.addButtonId);
        const previewList = document.getElementById(options.previewListId);
        const minOne = options.minOne === true;
        const requireFirst = options.requireFirst === true;

        if (!inputList || !addButton || !previewList) {
            return {
                reset: function () {}
            };
        }

        function updateRemoveButtonState() {
            const rows = inputList.querySelectorAll('.image-input-row');
            rows.forEach(function (row) {
                const removeButton = row.querySelector('.btn-remove-image-input');
                if (!removeButton) return;
                removeButton.disabled = minOne && rows.length <= 1;
            });
        }

        function renderPreview() {
            previewList.innerHTML = '';
            const files = [];

            inputList.querySelectorAll('input[type="file"]').forEach(function (input) {
                if (input.files && input.files[0]) {
                    files.push(input.files[0]);
                }
            });

            if (!files.length) {
                previewList.innerHTML = '<p class="read-meta empty-cell-message">Belum ada gambar dipilih.</p>';
                return;
            }

            files.forEach(function (file, index) {
                const item = document.createElement('div');
                item.className = 'upload-preview-item';
                const imageUrl = URL.createObjectURL(file);
                item.innerHTML = '<img src="' + imageUrl + '" alt="Preview ' + (index + 1) + '">';
                const img = item.querySelector('img');
                if (img) {
                    img.addEventListener('load', function () {
                        URL.revokeObjectURL(imageUrl);
                    });
                }
                previewList.appendChild(item);
            });
        }

        function addRow(isRequired) {
            const row = document.createElement('div');
            row.className = 'image-input-row';
            row.innerHTML =
                '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*"' + (isRequired ? ' required' : '') + '>' +
                '<button type="button" class="btn-remove-image-input">Hapus</button>';

            const input = row.querySelector('input[type="file"]');
            const removeButton = row.querySelector('.btn-remove-image-input');

            if (input) {
                input.addEventListener('change', renderPreview);
            }

            if (removeButton) {
                removeButton.addEventListener('click', function () {
                    row.remove();
                    if (minOne && !inputList.querySelector('.image-input-row')) {
                        addRow(requireFirst);
                    }
                    updateRemoveButtonState();
                    renderPreview();
                });
            }

            inputList.appendChild(row);
            updateRemoveButtonState();
            renderPreview();
        }

        addButton.addEventListener('click', function () {
            addRow(false);
        });

        function reset() {
            inputList.innerHTML = '';
            addRow(requireFirst);
        }

        reset();

        return {
            reset: reset
        };
    }

    const createImagePickerController = createImagePicker({
        inputListId: 'createBuletinImageInputList',
        addButtonId: 'addCreateBuletinImageInput',
        previewListId: 'createBuletinUploadPreviewList',
        minOne: true,
        requireFirst: true
    });

    const updateImagePickerController = createImagePicker({
        inputListId: 'updateBuletinImageInputList',
        addButtonId: 'addUpdateBuletinImageInput',
        previewListId: 'updateBuletinUploadPreviewList',
        minOne: true,
        requireFirst: false
    });

    createOpenButton.addEventListener('click', function () {
        createImagePickerController.reset();
        openOverlay(createOverlay, createInput);
    });

    document.querySelectorAll('.js-buletin-read-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const images = parseImages(button.dataset.images);
            readTitle.textContent = button.dataset.judul || 'Detail Edukasi';
            readMeta.textContent = 'Status: ' + (button.dataset.status || '-') + ' | Publish: ' + (button.dataset.published || '-') + ' | Views: ' + (button.dataset.views || '0') + ' | User: ' + (button.dataset.author || '-');
            readIsi.textContent = button.dataset.isi || '-';

            readImages.innerHTML = '';
            if (!images.length) {
                readImages.innerHTML = '<p class="read-meta empty-cell-message">Tidak ada gambar.</p>';
            } else {
                images.forEach(function (image) {
                    const img = document.createElement('img');
                    img.src = image.url;
                    img.alt = button.dataset.judul || 'Gambar edukasi';
                    readImages.appendChild(img);
                });
            }

            openOverlay(readOverlay);
        });
    });

    document.querySelectorAll('.js-buletin-update-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const images = parseImages(button.dataset.images);
            updateForm.action = button.dataset.updateUrl || '';
            updateId.value = button.dataset.id || '';
            updateJudul.value = button.dataset.judul || '';
            updateIsi.value = button.dataset.isi || '';
            updateStatus.value = button.dataset.status || 'draft';
            updatePublishedAt.value = button.dataset.publishedValue || '';
            updateImagePickerController.reset();

            existingImageList.innerHTML = '';
            if (images.length) {
                images.forEach(function (image, index) {
                    const item = document.createElement('div');
                    item.className = 'existing-image-item';
                    item.innerHTML =
                        '<img src="' + image.url + '" alt="Gambar ' + (index + 1) + '">' +
                        '<label><input type="checkbox" name="remove_image_ids[]" value="' + image.id + '"> Hapus gambar</label>';
                    existingImageList.appendChild(item);
                });
            } else {
                existingImageList.innerHTML = '<p class="read-meta empty-cell-message">Tidak ada gambar tersimpan.</p>';
            }

            openOverlay(updateOverlay, updateJudul);
        });
    });

    document.querySelectorAll('.js-buletin-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('Hapus edukasi ini?')) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeOverlay(overlay);
            }
        });
    });

    document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
        button.addEventListener('click', function () {
            const overlayId = button.getAttribute('data-close-overlay');
            if (!overlayId) return;
            closeOverlay(document.getElementById(overlayId));
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllOverlays();
        }
    });

    if (document.body.dataset.openCreatePopup === 'true') {
        createImagePickerController.reset();
        openOverlay(createOverlay, createInput);
    }
})();

/* =========================================================
   resources/views/pages/admin/galeri.blade.php
   ========================================================= */
(function () {
    const openButton         = document.getElementById('openGaleriPopup');
    const createOverlay      = document.getElementById('createGaleriOverlay');
    const readOverlay        = document.getElementById('readGaleriOverlay');
    const updateOverlay      = document.getElementById('updateGaleriOverlay');

    if (!openButton || !createOverlay || !readOverlay || !updateOverlay) return;

    const createJudul        = document.getElementById('createGaleriJudul');
    const createType         = document.getElementById('createGaleriType');
    const createImage        = document.getElementById('createGaleriImage');
    const createPreview      = document.getElementById('createGaleriPreview');
    const createDeskripsi    = document.getElementById('createGaleriDeskripsi');

    const readImage          = document.getElementById('readGaleriImage');
    const readJudul          = document.getElementById('readGaleriJudul');
    const readType           = document.getElementById('readGaleriType');
    const readDeskripsi      = document.getElementById('readGaleriDeskripsi');

    const createBgColor      = document.getElementById('createGaleriBg');
    const createBgHex        = document.getElementById('createGaleriBgHex');

    const readBgWrap         = document.getElementById('readGaleriBgWrap');
    const readBgSwatch       = document.getElementById('readGaleriBgSwatch');
    const readBgHexEl        = document.getElementById('readGaleriBgHex');

    const updateForm         = document.getElementById('updateGaleriForm');
    const updateKategori     = document.getElementById('updateGaleriKategori');
    const updateJudul        = document.getElementById('updateGaleriJudul');
    const updateType         = document.getElementById('updateGaleriType');
    const updateCurrentPrev  = document.getElementById('updateGaleriCurrentPreview');
    const updateImage        = document.getElementById('updateGaleriImage');
    const updateNewPrev      = document.getElementById('updateGaleriNewPreview');
    const updateDeskripsi    = document.getElementById('updateGaleriDeskripsi');
    const updateBgColor      = document.getElementById('updateGaleriBg');
    const updateBgHex        = document.getElementById('updateGaleriBgHex');

    function openOverlay(overlay, focusTarget) {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        if (focusTarget) window.setTimeout(function () { focusTarget.focus(); }, 0);
    }

    function closeOverlay(overlay) {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    function closeAllOverlays() {
        document.querySelectorAll('.popup-overlay.is-open').forEach(function (o) { closeOverlay(o); });
    }

    function renderPreview(container, file, fallbackUrl) {
        if (!container) return;
        container.innerHTML = '';
        if (file) {
            const url = URL.createObjectURL(file);
            container.innerHTML = '<img src="' + url + '" alt="Preview">';
            const img = container.querySelector('img');
            if (img) img.addEventListener('load', function () { URL.revokeObjectURL(url); });
            return;
        }
        if (fallbackUrl) {
            container.innerHTML = '<img src="' + fallbackUrl + '" alt="Foto galeri">';
        } else {
            container.innerHTML = '<p class="read-meta thumb-empty">Belum ada gambar.</p>';
        }
    }

    if (createBgColor) {
        createBgColor.addEventListener('input', function () {
            if (createBgHex) createBgHex.textContent = createBgColor.value;
        });
    }
    if (updateBgColor) {
        updateBgColor.addEventListener('input', function () {
            if (updateBgHex) updateBgHex.textContent = updateBgColor.value;
        });
    }

    openButton.addEventListener('click', function () {
        if (createJudul) createJudul.value = '';
        if (createType) createType.value = 'foto';
        if (createImage) createImage.value = '';
        if (createDeskripsi) createDeskripsi.value = '';
        if (createBgColor) { createBgColor.value = '#0d2d5e'; if (createBgHex) createBgHex.textContent = '#0d2d5e'; }
        renderPreview(createPreview, null, null);
        openOverlay(createOverlay, createJudul);
    });

    if (createImage) {
        createImage.addEventListener('change', function () {
            renderPreview(createPreview, createImage.files[0] || null, null);
        });
    }

    document.querySelectorAll('.js-galeri-read-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            renderPreview(readImage, null, btn.dataset.image || null);
            if (readJudul) readJudul.textContent = btn.dataset.judul || '-';
            if (readType) readType.textContent = 'Tipe: ' + (btn.dataset.type ? btn.dataset.type.charAt(0).toUpperCase() + btn.dataset.type.slice(1) : '-');
            if (readDeskripsi) readDeskripsi.textContent = btn.dataset.deskripsi || '-';
            var bg = btn.dataset.bg || '';
            if (readBgWrap) {
                if (bg) {
                    readBgWrap.style.display = '';
                    if (readBgSwatch) { readBgSwatch.style.background = bg; }
                    if (readBgHexEl) readBgHexEl.textContent = bg;
                } else {
                    readBgWrap.style.display = 'none';
                }
            }
            openOverlay(readOverlay);
        });
    });

    document.querySelectorAll('.js-galeri-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (updateForm) updateForm.action = btn.dataset.updateUrl || '';
            if (updateKategori) updateKategori.value = btn.dataset.kategori || '';
            if (updateJudul) updateJudul.value = btn.dataset.judul || '';
            if (updateType) updateType.value = btn.dataset.type || 'foto';
            if (updateDeskripsi) updateDeskripsi.value = btn.dataset.deskripsi || '';
            if (updateImage) updateImage.value = '';
            var bg = btn.dataset.bg || '#0d2d5e';
            if (updateBgColor) { updateBgColor.value = bg; if (updateBgHex) updateBgHex.textContent = bg; }
            renderPreview(updateCurrentPrev, null, btn.dataset.image || null);
            renderPreview(updateNewPrev, null, null);
            openOverlay(updateOverlay, updateJudul);
        });
    });

    if (updateImage) {
        updateImage.addEventListener('change', function () {
            renderPreview(updateNewPrev, updateImage.files[0] || null, null);
        });
    }

    document.querySelectorAll('.js-galeri-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('Hapus item galeri ini?')) event.preventDefault();
        });
    });

    document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) closeOverlay(overlay);
        });
    });

    document.querySelectorAll('[data-close-overlay]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = btn.getAttribute('data-close-overlay');
            if (id) closeOverlay(document.getElementById(id));
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeAllOverlays();
    });
})();
