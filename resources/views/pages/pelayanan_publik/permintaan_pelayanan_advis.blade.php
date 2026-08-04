@extends('master.app')

@section('title', 'Permintaan Pelayanan Advis - Balai Air Tanah')

@push('styles')
<style>
    .advis-section { padding: 22px 0 48px; background: #f4f6f9; }

    /* ── Intro + Alur Layanan ───────────────────────────── */
    .advis-top-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr);
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }
    .advis-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10,38,71,.05), 0 14px 34px rgba(10,38,71,.07);
        padding: 22px 26px;
        transition: box-shadow .22s ease, transform .22s ease;
    }
    .advis-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .advis-card:hover {
        box-shadow: 0 4px 14px rgba(10,38,71,.07), 0 20px 44px rgba(10,38,71,.1);
    }
    .advis-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 10px;
        color: var(--bat-primary);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .advis-kicker::before {
        content: '';
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .advis-intro { display: flex; flex-direction: column; gap: 10px; }
    .advis-intro-icon {
        position: relative;
        width: 66px; height: 66px;
        display: grid; place-items: center;
        border-radius: 18px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 25px;
        box-shadow: 0 14px 30px rgba(0,71,204,.28), 0 0 0 6px rgba(0,71,204,.06);
    }
    .advis-intro h2 {
        margin: 0 0 8px;
        color: var(--bat-primary-dark);
        font-size: 1.34rem;
        font-weight: 900;
        letter-spacing: -.01em;
    }
    .advis-intro p {
        margin: 0;
        color: #5f6c7b;
        font-size: .93rem;
        line-height: 1.8;
    }
    .advis-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        align-self: flex-start;
        padding: 12px 24px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(135deg, #0047cc, #123a8c 65%, #0a2456);
        color: #fff;
        font-size: .9rem;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(0,42,140,.28), inset 0 1px 0 rgba(255,255,255,.14);
        transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .advis-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0,42,140,.34), inset 0 1px 0 rgba(255,255,255,.18);
    }
    .advis-btn i:first-child { font-size: .78rem; }
    .advis-btn-arrow { font-size: .7rem; opacity: .85; transition: transform .2s ease; }
    .advis-btn:hover .advis-btn-arrow { transform: translateX(3px); }

    .advis-alur h3 {
        margin: 0 0 20px;
        color: var(--bat-primary-dark);
        font-size: 1.08rem;
        font-weight: 900;
    }
    .advis-alur-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
    }
    .advis-alur-step { text-align: center; position: relative; transition: transform .18s ease; }
    .advis-alur-step:hover { transform: translateY(-2px); }
    .advis-alur-step::after {
        content: '';
        position: absolute;
        top: 18px; right: -50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #a9c3ef, #d9e4f8);
        z-index: 0;
    }
    .advis-alur-step:last-child::after { display: none; }
    .advis-alur-num {
        position: relative;
        z-index: 1;
        width: 36px; height: 36px;
        margin: 0 auto 10px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .84rem;
        font-weight: 900;
        box-shadow: 0 8px 18px rgba(0,71,204,.28), 0 0 0 4px #fff;
    }
    .advis-alur-step:last-child .advis-alur-num {
        background: linear-gradient(135deg, #f0b429, #f6c34a);
        box-shadow: 0 8px 18px rgba(240,180,41,.35), 0 0 0 4px #fff;
    }
    .advis-alur-step strong {
        display: block;
        margin-bottom: 4px;
        color: var(--bat-primary-dark);
        font-size: .82rem;
        font-weight: 800;
    }
    .advis-alur-step span {
        display: block;
        color: #8290a3;
        font-size: .72rem;
        line-height: 1.55;
    }

    /* ── Persyaratan + Info Layanan ─────────────────────── */
    .advis-mid-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }
    .advis-mid-grid > .advis-card {
        display: flex;
        flex-direction: column;
    }
    .advis-card h3 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 18px;
        color: var(--bat-primary-dark);
        font-size: 1.05rem;
        font-weight: 900;
    }
    .advis-card h3 .advis-h-icon {
        width: 34px; height: 34px;
        display: grid; place-items: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .85rem;
        box-shadow: 0 8px 18px rgba(0,71,204,.22);
        flex-shrink: 0;
    }
    .advis-req-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .advis-req-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #eef2f8;
        border-radius: 10px;
        background: linear-gradient(180deg, #fbfdff, #f6f9ff);
        color: #344054;
        font-size: .85rem;
        font-weight: 600;
        line-height: 1.4;
        transition: border-color .18s ease, transform .18s ease, box-shadow .18s ease;
    }
    .advis-req-list li:hover {
        border-color: #c8dcff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(10,38,71,.06);
    }
    .advis-req-list li i {
        width: 22px; height: 22px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        font-size: .62rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(22,163,74,.28);
    }

    .advis-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
    }
    .advis-info-item {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 14px 13px 16px;
        border: 1px solid #eef2f8;
        border-radius: 12px;
        background: linear-gradient(180deg, #fbfdff, #f7faff);
    }
    .advis-info-item::before {
        content: '';
        position: absolute;
        left: 0; top: 10px; bottom: 10px;
        width: 3px;
        border-radius: 999px;
        background: linear-gradient(180deg, #0047cc, #16a3e8);
    }
    .advis-info-item-icon {
        width: 32px; height: 32px;
        display: grid; place-items: center;
        border-radius: 9px;
        background: #eef4ff;
        color: var(--bat-primary);
        font-size: .78rem;
        flex-shrink: 0;
    }
    .advis-info-item dt {
        color: #8290a3;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }
    .advis-info-item dd {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .87rem;
        font-weight: 700;
        line-height: 1.45;
    }
    .advis-info-item dd a { color: inherit; }

    /* ── Formulir ────────────────────────────────────────── */
    .advis-form-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 16px rgba(10,38,71,.06);
        padding: 22px 24px 20px;
    }
    .advis-form-card > h3 {
        margin: 0 0 4px;
        color: var(--bat-primary-dark);
        font-size: 1.15rem;
        font-weight: 900;
    }
    .advis-form-card > p {
        margin: 0 0 16px;
        color: #8290a3;
        font-size: .87rem;
    }
    .advis-form-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 16px;
    }
    .advis-form-group h4 {
        margin: 0 0 10px;
        padding-bottom: 8px;
        border-bottom: 2px solid #eef2f8;
        color: var(--bat-primary);
        font-size: .84rem;
        font-weight: 900;
    }
    .advis-field { margin-bottom: 10px; }
    .advis-field:last-child { margin-bottom: 0; }
    .advis-field label {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: .82rem;
        font-weight: 700;
    }
    .advis-field .req { color: #e11d48; }
    .advis-field input[type="text"],
    .advis-field input[type="email"],
    .advis-field input[type="tel"],
    .advis-field textarea,
    .advis-field select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #dde4ee;
        border-radius: 8px;
        background: #fbfcfe;
        color: #172335;
        font-size: .86rem;
        font-family: inherit;
        transition: border-color .15s ease, background .15s ease;
    }
    .advis-field input:focus,
    .advis-field textarea:focus,
    .advis-field select:focus {
        outline: none;
        border-color: #7fa8f0;
        background: #fff;
    }
    .advis-field textarea { resize: vertical; min-height: 56px; }

    .advis-bottom-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
        gap: 16px;
        margin-bottom: 16px;
        align-items: start;
    }
    .advis-dropzone {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 20px 20px;
        border: 2px dashed #cfdaee;
        border-radius: 12px;
        background: #fafcff;
        color: #8290a3;
        text-align: center;
        cursor: pointer;
        transition: border-color .18s ease, background .18s ease;
    }
    .advis-dropzone:hover { border-color: #7fa8f0; background: #f4f8ff; }
    .advis-dropzone i { font-size: 1.5rem; color: var(--bat-primary); margin-bottom: 4px; }
    .advis-dropzone strong { color: var(--bat-primary-dark); font-size: .86rem; }
    .advis-dropzone span { font-size: .74rem; }
    .advis-dropzone input[type="file"] { display: none; }

    .advis-check-list { display: grid; gap: 10px; }
    .advis-check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #475467;
        font-size: .84rem;
        line-height: 1.6;
    }
    .advis-check-item input { margin-top: 4px; flex-shrink: 0; }

    .advis-form-actions { display: flex; gap: 12px; }
    .advis-submit-btn,
    .advis-reset-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 24px;
        border-radius: 9px;
        font-size: .88rem;
        font-weight: 800;
        cursor: pointer;
        transition: background .18s ease, transform .18s ease;
    }
    .advis-submit-btn {
        border: 0;
        background: var(--bat-primary);
        color: #fff;
    }
    .advis-submit-btn:hover { background: #0f2d5a; transform: translateY(-1px); }
    .advis-reset-btn {
        border: 1px solid #dde4ee;
        background: #fff;
        color: #475467;
    }
    .advis-reset-btn:hover { background: #f4f6f9; }

    @media (max-width: 991px) {
        .advis-top-grid, .advis-mid-grid, .advis-bottom-grid { grid-template-columns: 1fr; }
        .advis-form-grid { grid-template-columns: 1fr 1fr; }
        .advis-alur-steps { grid-template-columns: repeat(3, minmax(0,1fr)); row-gap: 22px; }
        .advis-alur-step::after { display: none; }
    }
    @media (max-width: 620px) {
        .advis-form-grid { grid-template-columns: 1fr; }
        .advis-req-list { grid-template-columns: 1fr; }
        .advis-info-grid { grid-template-columns: 1fr; }
        .advis-alur-steps { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permintaan Pelayanan Advis'])

<section class="advis-section">
    <div class="container">
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <a href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">Pelayanan Publik</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Permintaan Pelayanan Advis</span>
        </nav>

        {{-- Intro + Alur Layanan --}}
        <div class="advis-top-grid">
            <div class="advis-card advis-intro">
                <div class="advis-intro-icon"><i class="fa-solid fa-file-signature"></i></div>
                <div>
                    <span class="advis-kicker">Layanan Publik</span>
                    <h2>Permintaan Pelayanan Advis</h2>
                    <p>Layanan ini disediakan sebagai kanal permohonan advis teknis di bidang air tanah. Pemohon dapat menyampaikan kebutuhan, permasalahan, atau informasi awal untuk ditindaklanjuti sesuai kewenangan Balai Air Tanah.</p>
                </div>
                <a href="#advis-formulir" class="advis-btn" id="advis-isi-formulir-btn">
                    <i class="fa-solid fa-pen-to-square"></i> Isi Formulir
                    <i class="fa-solid fa-arrow-right advis-btn-arrow"></i>
                </a>
            </div>

            <div class="advis-card advis-alur">
                <h3>Alur Layanan</h3>
                <div class="advis-alur-steps">
                    <div class="advis-alur-step">
                        <div class="advis-alur-num">1</div>
                        <strong>Isi Formulir</strong>
                        <span>Lengkapi formulir permohonan</span>
                    </div>
                    <div class="advis-alur-step">
                        <div class="advis-alur-num">2</div>
                        <strong>Verifikasi</strong>
                        <span>Verifikasi kelengkapan data oleh petugas</span>
                    </div>
                    <div class="advis-alur-step">
                        <div class="advis-alur-num">3</div>
                        <strong>Klarifikasi</strong>
                        <span>Klarifikasi informasi jika diperlukan</span>
                    </div>
                    <div class="advis-alur-step">
                        <div class="advis-alur-num">4</div>
                        <strong>Tindak Lanjut</strong>
                        <span>Proses tindak lanjut sesuai kewenangan</span>
                    </div>
                    <div class="advis-alur-step">
                        <div class="advis-alur-num">5</div>
                        <strong>Hasil Disampaikan</strong>
                        <span>Hasil advis disampaikan kepada pemohon</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Persyaratan + Informasi Layanan --}}
        <div class="advis-mid-grid">
            <div class="advis-card">
                <h3><span class="advis-h-icon"><i class="fa-solid fa-clipboard-check"></i></span> Persyaratan</h3>
                <ul class="advis-req-list">
                    <li><i class="fa-solid fa-check"></i> Identitas pemohon</li>
                    <li><i class="fa-solid fa-check"></i> Lokasi objek permohonan</li>
                    <li><i class="fa-solid fa-check"></i> Surat permohonan resmi (jika dari instansi)</li>
                    <li><i class="fa-solid fa-check"></i> Data teknis pendukung (jika tersedia)</li>
                    <li><i class="fa-solid fa-check"></i> Uraian kebutuhan advis</li>
                    <li><i class="fa-solid fa-check"></i> Foto atau peta lokasi (jika tersedia)</li>
                </ul>
            </div>

            <div class="advis-card">
                <h3><span class="advis-h-icon"><i class="fa-solid fa-circle-info"></i></span> Informasi Layanan</h3>
                <dl class="advis-info-grid">
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div>
                            <dt>Biaya</dt>
                            <dd>Tidak dipungut biaya</dd>
                        </div>
                    </div>
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <dt>Kontak</dt>
                            <dd><a href="mailto:balaiairtanah@pu.go.id">balaiairtanah@pu.go.id</a></dd>
                        </div>
                    </div>
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <div>
                            <dt>Waktu Layanan</dt>
                            <dd>Senin&ndash;Jumat</dd>
                        </div>
                    </div>
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <dt>Telepon</dt>
                            <dd>(022) 20463967</dd>
                        </div>
                    </div>
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-regular fa-clock"></i></div>
                        <div>
                            <dt>Jam Layanan</dt>
                            <dd>08.00&ndash;16.00 WIB</dd>
                        </div>
                    </div>
                    <div class="advis-info-item">
                        <div class="advis-info-item-icon"><i class="fa-solid fa-note-sticky"></i></div>
                        <div>
                            <dt>Catatan</dt>
                            <dd>Tindak lanjut dilakukan setelah verifikasi permohonan</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Formulir Permohonan --}}
        <div class="advis-form-card" id="advis-formulir" style="display:none;">
            <h3>Formulir Permohonan</h3>
            <p>Silakan lengkapi formulir berikut dengan data yang benar dan jelas.</p>

            <form method="POST" action="#">
                @csrf
                <div class="advis-form-grid">
                    <div class="advis-form-group">
                        <h4>1. Data Pemohon</h4>
                        <div class="advis-field">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="advis-field">
                            <label>Instansi/Perorangan <span class="req">*</span></label>
                            <select name="jenis_pemohon" required>
                                <option value="" selected disabled>Pilih instansi atau perorangan</option>
                                <option value="instansi">Instansi</option>
                                <option value="perorangan">Perorangan</option>
                            </select>
                        </div>
                        <div class="advis-field">
                            <label>Jabatan <span class="req">*</span></label>
                            <input type="text" name="jabatan" placeholder="Masukkan jabatan" required>
                        </div>
                        <div class="advis-field">
                            <label>Nomor Telepon/WhatsApp <span class="req">*</span></label>
                            <input type="tel" name="telepon" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="advis-field">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" placeholder="nama@email.com" required>
                        </div>
                        <div class="advis-field">
                            <label>Alamat <span class="req">*</span></label>
                            <textarea name="alamat" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                    </div>

                    <div class="advis-form-group">
                        <h4>2. Detail Permohonan</h4>
                        <div class="advis-field">
                            <label>Jenis Permohonan Advis <span class="req">*</span></label>
                            <select name="jenis_permohonan" required>
                                <option value="" selected disabled>Pilih jenis permohonan</option>
                                <option value="pengeboran">Advis Pengeboran Air Tanah</option>
                                <option value="pemanfaatan">Advis Pemanfaatan Air Tanah</option>
                                <option value="konservasi">Advis Konservasi Air Tanah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="advis-field">
                            <label>Perihal Permohonan <span class="req">*</span></label>
                            <input type="text" name="perihal" placeholder="Masukkan perihal permohonan" required>
                        </div>
                        <div class="advis-field">
                            <label>Uraian Permasalahan/Kebutuhan Advis <span class="req">*</span></label>
                            <textarea name="uraian" placeholder="Jelaskan permasalahan atau kebutuhan advis secara rinci" required></textarea>
                        </div>
                        <div class="advis-field">
                            <label>Tujuan Permohonan <span class="req">*</span></label>
                            <select name="tujuan" required>
                                <option value="" selected disabled>Pilih tujuan permohonan</option>
                                <option value="perizinan">Kelengkapan Perizinan</option>
                                <option value="teknis">Konsultasi Teknis</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="advis-form-group">
                        <h4>3. Informasi Lokasi</h4>
                        <div class="advis-field">
                            <label>Lokasi Kegiatan/Objek Permohonan <span class="req">*</span></label>
                            <input type="text" name="lokasi" placeholder="Masukkan lokasi kegiatan/objek" required>
                        </div>
                        <div class="advis-field">
                            <label>Koordinat Lokasi <span class="req">*</span></label>
                            <input type="text" name="koordinat" placeholder="Contoh: -6.914744, 107.609810" required>
                        </div>
                        <div class="advis-field">
                            <label>Kondisi Eksisting <span class="req">*</span></label>
                            <textarea name="kondisi_eksisting" placeholder="Jelaskan kondisi eksisting di lokasi" required></textarea>
                        </div>
                    </div>

                    <div class="advis-form-group">
                        <h4>4. Data Teknis Awal</h4>
                        <div class="advis-field">
                            <label>Jenis Sumber Air Tanah <span class="req">*</span></label>
                            <select name="jenis_sumber_air" required>
                                <option value="" selected disabled>Pilih jenis sumber air tanah</option>
                                <option value="sumur_bor">Sumur Bor</option>
                                <option value="sumur_gali">Sumur Gali</option>
                                <option value="mata_air">Mata Air</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="advis-field">
                            <label>Kedalaman Sumur (m) <span class="req">*</span></label>
                            <input type="text" name="kedalaman_sumur" placeholder="Contoh: 50" required>
                        </div>
                        <div class="advis-field">
                            <label>Kondisi Air <span class="req">*</span></label>
                            <input type="text" name="kondisi_air" placeholder="Contoh: Jernih, keruh, berbau" required>
                        </div>
                        <div class="advis-field">
                            <label>Keterangan Teknis Lainnya <span class="req">*</span></label>
                            <textarea name="keterangan_teknis" placeholder="Masukkan keterangan teknis lainnya" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="advis-bottom-grid">
                    <div>
                        <h4 style="margin:0 0 12px;color:var(--bat-primary-dark);font-size:.9rem;font-weight:900;">5. Lampiran <span class="req">*</span></h4>
                        <label class="advis-dropzone">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <strong>Seret dan lepas file di sini</strong>
                            <span>atau klik untuk memilih file</span>
                            <span>PDF, JPG, PNG, DOC, XLS (Maks. 10 MB per file)</span>
                            <input type="file" name="lampiran[]" multiple required>
                        </label>
                    </div>
                    <div>
                        <h4 style="margin:0 0 12px;color:var(--bat-primary-dark);font-size:.9rem;font-weight:900;">6. Pernyataan</h4>
                        <div class="advis-check-list">
                            <label class="advis-check-item">
                                <input type="checkbox" name="pernyataan_benar" required>
                                Saya menyatakan bahwa seluruh data dan informasi yang disampaikan di atas adalah benar dan dapat dipertanggungjawabkan.
                            </label>
                            <label class="advis-check-item">
                                <input type="checkbox" name="pernyataan_bersedia" required>
                                Saya bersedia dihubungi oleh petugas Balai Air Tanah terkait klarifikasi atau tindak lanjut permohonan ini.
                            </label>
                        </div>
                    </div>
                </div>

                <div class="advis-form-actions">
                    <button type="submit" class="advis-submit-btn"><i class="fa-solid fa-paper-plane"></i> Kirim Permohonan</button>
                    <button type="reset" class="advis-reset-btn"><i class="fa-solid fa-rotate-left"></i> Reset Form</button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('advis-isi-formulir-btn')?.addEventListener('click', function (e) {
        e.preventDefault();
        var form = document.getElementById('advis-formulir');
        var isHidden = form.style.display === 'none';
        form.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
</script>
@endpush
@endsection
