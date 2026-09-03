@extends('master.app')

@section('title', 'Layanan Data dan Informasi - Balai Air Tanah')

@push('styles')
<style>
    .batdata-section {
        padding: 22px 0 48px;
        background:
            linear-gradient(180deg, #f6f9ff 0%, #ffffff 42%, #f4f7fb 100%);
    }

    /* ── Intro + Alur Layanan ─────────────────────────────── */
    .batdata-top-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }
    .batdata-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10, 38, 71, .05), 0 14px 34px rgba(10, 38, 71, .07);
        padding: 22px 26px;
        transition: box-shadow .22s ease, transform .22s ease;
    }
    .batdata-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .batdata-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 14px rgba(10, 38, 71, .07), 0 22px 48px rgba(10, 38, 71, .12);
    }
    .batdata-kicker {
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
    .batdata-kicker::before {
        content: '';
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .batdata-intro { display: flex; flex-direction: column; gap: 10px; }
    .batdata-intro-icon {
        position: relative;
        width: 66px;
        height: 66px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 25px;
        box-shadow: 0 14px 30px rgba(0, 71, 204, .28), 0 0 0 6px rgba(0, 71, 204, .06);
    }
    .batdata-intro h2 {
        margin: 0 0 8px;
        color: var(--bat-primary-dark);
        font-size: 1.34rem;
        font-weight: 900;
        letter-spacing: -.01em;
    }
    .batdata-intro p {
        margin: 0;
        color: #5f6c7b;
        font-size: .93rem;
        line-height: 1.8;
    }
    .batdata-btn {
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
        box-shadow: 0 10px 24px rgba(0, 42, 140, .28), inset 0 1px 0 rgba(255, 255, 255, .14);
        transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .batdata-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0, 42, 140, .34), inset 0 1px 0 rgba(255, 255, 255, .18);
    }
    .batdata-btn i:first-child { font-size: .78rem; }
    .batdata-btn-arrow { font-size: .7rem; opacity: .85; transition: transform .2s ease; }
    .batdata-btn:hover .batdata-btn-arrow { transform: translateX(3px); }

    .batdata-alur h3 {
        margin: 0 0 20px;
        color: var(--bat-primary-dark);
        font-size: 1.08rem;
        font-weight: 900;
    }
    .batdata-alur-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
    }
    .batdata-alur-step { text-align: center; position: relative; transition: transform .18s ease; }
    .batdata-alur-step:hover { transform: translateY(-2px); }
    .batdata-alur-step::after {
        content: '';
        position: absolute;
        top: 20px;
        right: -50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #a9c3ef, #d9e4f8);
        z-index: 0;
    }
    .batdata-alur-step:last-child::after { display: none; }
    .batdata-alur-icon-wrap {
        position: relative;
        width: 40px;
        height: 40px;
        margin: 0 auto 10px;
        z-index: 1;
    }
    .batdata-alur-icon {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .9rem;
        box-shadow: 0 8px 18px rgba(0, 71, 204, .28), 0 0 0 4px #fff;
    }
    .batdata-alur-num {
        position: absolute;
        top: -7px;
        right: -9px;
        z-index: 2;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        display: grid;
        place-items: center;
        border-radius: 999px;
        background: var(--bat-primary);
        color: #fff;
        font-size: .64rem;
        font-weight: 900;
        border: 2px solid #fff;
    }
    .batdata-alur-step strong {
        display: block;
        margin-bottom: 4px;
        color: var(--bat-primary-dark);
        font-size: .82rem;
        font-weight: 800;
    }
    .batdata-alur-step span {
        display: block;
        color: #8290a3;
        font-size: .72rem;
        line-height: 1.55;
    }

    /* ── Persyaratan + Informasi Layanan ──────────────────── */
    .batdata-mid-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 14px;
        margin-bottom: 14px;
        align-items: stretch;
    }
    .batdata-mid-grid > .batdata-card {
        display: flex;
        flex-direction: column;
    }
    .batdata-card h3 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 18px;
        color: var(--bat-primary-dark);
        font-size: 1.05rem;
        font-weight: 900;
    }
    .batdata-card h3 .batdata-h-icon {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .85rem;
        box-shadow: 0 8px 18px rgba(0, 71, 204, .22);
        flex-shrink: 0;
    }
    .batdata-req-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: start;
        gap: 10px;
        flex: 1;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .batdata-req-list li {
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
    .batdata-req-list li:hover {
        border-color: #c8dcff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(10, 38, 71, .06);
    }
    .batdata-req-list li i {
        width: 22px;
        height: 22px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        font-size: .62rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(22, 163, 74, .28);
    }
    .batdata-req-note {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: auto;
        padding: 12px 14px;
        border-radius: 10px;
        background: #fef9e7;
        border: 1px solid #fde68a;
        color: #92400e;
        font-size: .8rem;
        font-weight: 600;
        line-height: 1.5;
    }
    .batdata-req-note i { margin-top: 2px; color: #d97706; flex-shrink: 0; }

    .batdata-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
    }
    .batdata-info-item {
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
    .batdata-info-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10px;
        bottom: 10px;
        width: 3px;
        border-radius: 999px;
        background: linear-gradient(180deg, #0047cc, #16a3e8);
    }
    .batdata-info-item-icon {
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        background: #eef4ff;
        color: var(--bat-primary);
        font-size: .78rem;
        flex-shrink: 0;
    }
    .batdata-info-item dt {
        color: #8290a3;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }
    .batdata-info-item dd {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .87rem;
        font-weight: 700;
        line-height: 1.45;
    }
    .batdata-info-item dd a { color: inherit; }

    /* ── Formulir Permohonan ──────────────────────────────── */
    .batdata-form-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 16px rgba(10, 38, 71, .06);
        padding: 22px 24px 20px;
        scroll-margin-top: 120px;
    }
    .batdata-form-card > h3 {
        margin: 0 0 4px;
        color: var(--bat-primary-dark);
        font-size: 1.15rem;
        font-weight: 900;
    }
    .batdata-form-card > p {
        margin: 0 0 16px;
        color: #8290a3;
        font-size: .87rem;
    }
    .batdata-form-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        align-items: start;
        margin-bottom: 20px;
    }
    .batdata-form-group {
        padding: 20px;
        border-radius: 12px;
        background: #fbfcfe;
        border: 1px solid #edf2f9;
    }
    .batdata-section-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e6ecf5;
    }
    .batdata-section-num {
        width: 26px;
        height: 26px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .78rem;
        font-weight: 900;
    }
    .batdata-section-head h4 {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .98rem;
        font-weight: 900;
    }
    .batdata-field { margin-bottom: 10px; }
    .batdata-field:last-child { margin-bottom: 0; }
    .batdata-field label {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: .82rem;
        font-weight: 700;
    }
    .batdata-field .req { color: #e11d48; }
    .batdata-field input[type="text"],
    .batdata-field input[type="email"],
    .batdata-field input[type="tel"],
    .batdata-field textarea,
    .batdata-field select {
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
    .batdata-field input:focus,
    .batdata-field textarea:focus,
    .batdata-field select:focus {
        outline: none;
        border-color: #7fa8f0;
        background: #fff;
    }
    .batdata-field textarea { resize: vertical; min-height: 56px; }

    .batdata-dropzone {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 150px;
        padding: 28px 20px;
        border: 2px dashed #cfdaee;
        border-radius: 14px;
        background: linear-gradient(180deg, #fbfdff, #f7faff);
        color: #8290a3;
        text-align: center;
        cursor: pointer;
        transition: border-color .18s ease, background .18s ease;
    }
    .batdata-dropzone:hover { border-color: #7fa8f0; background: #f4f8ff; }
    .batdata-dropzone i { font-size: 1.6rem; color: var(--bat-primary); margin-bottom: 4px; }
    .batdata-dropzone strong { color: var(--bat-primary-dark); font-size: .86rem; }
    .batdata-dropzone span { font-size: .74rem; }
    .batdata-dropzone input[type="file"] { display: none; }
    .file-name-tag {
        display: none;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #eef4ff;
        color: #0047cc;
        font-size: .75rem;
        font-weight: 700;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .remove-file-btn {
        cursor: pointer;
        color: #dc3545;
        font-size: .85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .remove-file-btn:hover {
        color: #bb2d3b;
    }

    .batdata-pernyataan {
        margin-top: 24px;
        padding: 18px 22px;
        border: 1px solid #dce7fb;
        border-radius: 14px;
        background: linear-gradient(180deg, #fbfdff, #f5f8ff);
    }
    .batdata-check-list { display: grid; gap: 12px; }
    .batdata-check-item {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px 16px;
        border: 1px solid #eef2f8;
        border-radius: 10px;
        background: #fff;
        color: #475467;
        font-size: .85rem;
        line-height: 1.6;
        cursor: pointer;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    .batdata-check-item:hover {
        border-color: #c8dcff;
        box-shadow: 0 6px 16px rgba(10, 38, 71, .05);
    }
    .batdata-check-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .batdata-check-box {
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        margin-top: 2px;
        display: grid;
        place-items: center;
        border-radius: 6px;
        border: 1.5px solid #c3d2ec;
        background: #fff;
        color: #fff;
        font-size: .58rem;
        transition: background .15s ease, border-color .15s ease, box-shadow .15s ease;
    }
    .batdata-check-item input[type="checkbox"]:checked + .batdata-check-box {
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        border-color: transparent;
        box-shadow: 0 4px 10px rgba(0, 71, 204, .25);
    }
    .batdata-check-item input[type="checkbox"]:focus-visible + .batdata-check-box {
        outline: 2px solid #7fa8f0;
        outline-offset: 2px;
    }
    .batdata-check-text { flex: 1; min-width: 0; }
    .batdata-check-item input[type="checkbox"]:checked ~ .batdata-check-text {
        color: var(--bat-primary-dark);
        font-weight: 700;
    }

    .data-form-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
        padding-top: 10px;
    }
    .magang-action-btns { display: flex; gap: 12px; }
    .magang-form-note {
        flex-basis: 100%;
        color: #8290a3;
        font-size: .78rem;
        text-align: center;
    }
    .magang-submit-btn,
    .magang-reset-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 26px;
        border-radius: 999px;
        font-size: .88rem;
        font-weight: 800;
        cursor: pointer;
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }
    .magang-submit-btn {
        border: 0;
        background: linear-gradient(135deg, #0047cc, #123a8c);
        color: #fff;
        box-shadow: 0 8px 20px rgba(0, 71, 204, .24);
    }
    .magang-submit-btn:hover {
        background: linear-gradient(135deg, #0036a3, #0a2456);
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(0, 71, 204, .32);
    }
    .magang-reset-btn {
        border: 1px solid #dde4ee;
        background: #fff;
        color: #475467;
    }
    .magang-reset-btn:hover {
        background: #f4f6f9;
        color: #172335;
    }

    @media (max-width: 991px) {
        .batdata-top-grid,
        .batdata-mid-grid { grid-template-columns: 1fr; }
        .batdata-form-grid { grid-template-columns: 1fr 1fr; }
        .batdata-alur-steps { grid-template-columns: repeat(3, minmax(0, 1fr)); row-gap: 22px; }
        .batdata-alur-step::after { display: none; }
    }
    @media (max-width: 620px) {
        .batdata-form-grid { grid-template-columns: 1fr; }
        .batdata-req-list { grid-template-columns: 1fr; }
        .batdata-info-grid { grid-template-columns: 1fr; }
        .batdata-alur-steps { grid-template-columns: 1fr 1fr; }
        .data-form-actions { flex-direction: column; align-items: stretch; }
        .magang-action-btns { flex-direction: column; }
        .magang-form-note { text-align: center; }
        .magang-submit-btn,
        .magang-reset-btn { justify-content: center; }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Layanan Data dan Informasi'])

<section class="batdata-section">
    <div class="container">
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span>Pelayanan Publik</span>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Layanan Data dan Informasi</span>
        </nav>

        {{-- Intro + Alur Layanan --}}
        <div class="batdata-top-grid">
            <div class="batdata-card batdata-intro wow fadeInDown" data-wow-delay="0.05s">
                <div class="batdata-intro-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div>
                    <span class="batdata-kicker">Pelayanan Publik</span>
                    <h2>Layanan Data dan Informasi</h2>
                    <p>Layanan ini disediakan untuk memfasilitasi permintaan data air tanah, dokumen teknis, peta, dan informasi publik yang dikelola oleh Balai Air Tanah. Pemohon dapat menyampaikan kebutuhan data/informasi melalui formulir berikut untuk ditindaklanjuti sesuai ketersediaan data dan ketentuan yang berlaku.</p>
                </div>
                <a href="#batdata-formulir" class="batdata-btn" id="batdata-isi-formulir-btn">
                    <i class="fa-solid fa-pen-to-square"></i> Isi Formulir
                    <i class="fa-solid fa-arrow-right batdata-btn-arrow"></i>
                </a>
            </div>

            <div class="batdata-card batdata-alur wow fadeInUp" data-wow-delay="0.15s">
                <h3><i class="fa-solid fa-diagram-project text-primary me-2"></i> Alur Layanan</h3>
                <div class="batdata-alur-steps">
                    <div class="batdata-alur-step">
                        <div class="batdata-alur-icon-wrap">
                            <div class="batdata-alur-icon"><i class="fa-solid fa-file-pen"></i></div>
                            <span class="batdata-alur-num">1</span>
                        </div>
                        <strong>Isi Formulir</strong>
                        <span>Lengkapi formulir permohonan data</span>
                    </div>
                    <div class="batdata-alur-step">
                        <div class="batdata-alur-icon-wrap">
                            <div class="batdata-alur-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                            <span class="batdata-alur-num">2</span>
                        </div>
                        <strong>Verifikasi</strong>
                        <span>Verifikasi kelengkapan data oleh petugas</span>
                    </div>
                    <div class="batdata-alur-step">
                        <div class="batdata-alur-icon-wrap">
                            <div class="batdata-alur-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                            <span class="batdata-alur-num">3</span>
                        </div>
                        <strong>Pemeriksaan Ketersediaan Data</strong>
                        <span>Ketersediaan data diperiksa dan disesuaikan</span>
                    </div>
                    <div class="batdata-alur-step">
                        <div class="batdata-alur-icon-wrap">
                            <div class="batdata-alur-icon"><i class="fa-solid fa-list-check"></i></div>
                            <span class="batdata-alur-num">4</span>
                        </div>
                        <strong>Tindak Lanjut</strong>
                        <span>Permohonan diproses sesuai ketersediaan data</span>
                    </div>
                    <div class="batdata-alur-step">
                        <div class="batdata-alur-icon-wrap">
                            <div class="batdata-alur-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                            <span class="batdata-alur-num">5</span>
                        </div>
                        <strong>Hasil Disampaikan</strong>
                        <span>Hasil/data disampaikan kepada pemohon</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Persyaratan + Informasi Layanan --}}
        <div class="batdata-mid-grid">
            <div class="batdata-card wow fadeInLeft" data-wow-delay="0.2s">
                <h3><span class="batdata-h-icon"><i class="fa-solid fa-clipboard-check"></i></span> Persyaratan</h3>
                <ul class="batdata-req-list">
                    <li><i class="fa-solid fa-check"></i> Identitas pemohon</li>
                    <li><i class="fa-solid fa-check"></i> Surat permohonan resmi (jika dari instansi)</li>
                    <li><i class="fa-solid fa-check"></i> Uraian data/informasi yang dibutuhkan</li>
                    <li><i class="fa-solid fa-check"></i> Wilayah atau lokasi data</li>
                    <li><i class="fa-solid fa-check"></i> Tujuan penggunaan data</li>
                    <li><i class="fa-solid fa-check"></i> Dokumen pendukung (jika diperlukan)</li>
                </ul>
                <div class="batdata-req-note">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Pastikan seluruh berkas telah dilengkapi sebelum pengajuan. Berkas yang tidak lengkap akan ditunda hingga dokumen pelengkap diterima.</span>
                </div>
            </div>

            <div class="batdata-card wow fadeInRight" data-wow-delay="0.3s">
                <h3><span class="batdata-h-icon"><i class="fa-solid fa-circle-info"></i></span> Informasi Layanan</h3>
                <dl class="batdata-info-grid">
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div>
                            <dt>Biaya</dt>
                            <dd>Tidak dipungut biaya</dd>
                        </div>
                    </div>
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <div>
                            <dt>Waktu Layanan</dt>
                            <dd>Senin&ndash;Jumat</dd>
                        </div>
                    </div>
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-regular fa-clock"></i></div>
                        <div>
                            <dt>Jam Layanan</dt>
                            <dd>07.30&ndash;16.00 WIB</dd>
                        </div>
                    </div>
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <dt>Telepon</dt>
                            <dd>(022) 20463967</dd>
                        </div>
                    </div>
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <dt>Email</dt>
                            <dd><a href="mailto:balaiirtanah@pu.go.id">balaiirtanah@pu.go.id</a></dd>
                        </div>
                    </div>
                    <div class="batdata-info-item">
                        <div class="batdata-info-item-icon"><i class="fa-solid fa-note-sticky"></i></div>
                        <div>
                            <dt>Catatan</dt>
                            <dd>Jadwal kegiatan disesuaikan dengan ketersediaan waktu &amp; kapasitas layanan</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Formulir Permohonan --}}
        <div class="batdata-form-card" id="batdata-formulir" style="display: none;">
            <h3>Formulir Permohonan</h3>
            <p>Silakan lengkapi formulir berikut dengan data yang benar dan jelas.</p>

            <div class="batdata-form-grid">
                    <div class="batdata-form-group">
                        <div class="batdata-section-head">
                            <span class="batdata-section-num">1</span>
                            <h4>Data Pemohon</h4>
                        </div>
                        <div class="batdata-field">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="batdata-field">
                            <label>Instansi/Perorangan <span class="req">*</span></label>
                            <select name="jenis_pemohon" required>
                                <option value="" selected disabled>Pilih instansi atau perorangan</option>
                                <option value="instansi">Instansi</option>
                                <option value="perorangan">Perorangan</option>
                            </select>
                        </div>
                        <div class="batdata-field">
                            <label>Jabatan <span class="req">*</span></label>
                            <input type="text" name="jabatan" placeholder="Masukkan jabatan" required>
                        </div>
                        <div class="batdata-field">
                            <label>Nomor Telepon/WhatsApp <span class="req">*</span></label>
                            <input type="tel" name="telepon" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="batdata-field">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" placeholder="nama@email.com" required>
                        </div>
                        <div class="batdata-field">
                            <label>Alamat <span class="req">*</span></label>
                            <textarea name="alamat" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                    </div>

                    <div class="batdata-form-group">
                        <div class="batdata-section-head">
                            <span class="batdata-section-num">2</span>
                            <h4>Detail Permohonan</h4>
                        </div>
                        <div class="batdata-field">
                            <label>Jenis Informasi <span class="req">*</span></label>
                            <select name="jenis_informasi" required>
                                <option value="" selected disabled>Pilih jenis informasi</option>
                                <option value="data_air_tanah">Data Air Tanah</option>
                                <option value="dokumen_teknis">Dokumen Teknis</option>
                                <option value="peta">Peta</option>
                                <option value="informasi_publik">Informasi Publik</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="batdata-field">
                            <label>Tahun Data <span class="req">*</span></label>
                            <input type="text" name="tahun_data" placeholder="Contoh: 2024" required>
                        </div>
                        <div class="batdata-field">
                            <label>Uraian Data/Informasi yang Dibutuhkan <span class="req">*</span></label>
                            <textarea name="uraian" placeholder="Jelaskan data atau informasi yang dibutuhkan secara rinci" required></textarea>
                        </div>
                        <div class="batdata-field">
                            <label>Wilayah/Lokasi Data <span class="req">*</span></label>
                            <input type="text" name="wilayah" placeholder="Contoh: Kabupaten Bandung, Jawa Barat" required>
                        </div>
                    </div>

                    <div class="batdata-form-group">
                        <div class="batdata-section-head">
                            <span class="batdata-section-num">3</span>
                            <h4>Tujuan Penggunaan</h4>
                        </div>
                        <div class="batdata-field">
                            <label>Tujuan Penggunaan Data <span class="req">*</span></label>
                            <select name="tujuan_penggunaan" required>
                                <option value="" selected disabled>Pilih tujuan penggunaan data</option>
                                <option value="penelitian">Penelitian/Kajian</option>
                                <option value="perencanaan">Perencanaan Pembangunan</option>
                                <option value="usaha">Kepentingan Usaha/Bisnis</option>
                                <option value="tugas">Tugas/Kedinasan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="batdata-field">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" placeholder="Masukkan keterangan tambahan (jika ada)"></textarea>
                        </div>
                    </div>

                    {{-- 4. Lampiran + Pernyataan --}}
                    <div>
                        <div class="batdata-form-group">
                            <div class="batdata-section-head">
                                <span class="batdata-section-num">4</span>
                                <h4>Lampiran</h4>
                            </div>

                            <div class="batdata-field">
                                <label>Unggah Dokumen Surat Permohonan Data &amp; Informasi <span class="req">*</span></label>
                            </div>

                            <label class="batdata-dropzone">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <strong>Seret dan lepas file di sini</strong>
                                <span>atau klik untuk memilih file</span>
                                <span>PDF, JPG, PNG, DOC, DOCX (Maks. 5MB)</span>
                                <input type="file" name="lampiran" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <span class="file-name-tag"></span>
                            </label>
                        </div>

                        <div class="batdata-pernyataan">
                            <div class="batdata-section-head">
                                <span class="batdata-section-num">5</span>
                                <h4>Pernyataan</h4>
                            </div>
                            <div class="batdata-check-list">
                                <label class="batdata-check-item">
                                    <input type="checkbox" name="pernyataan_benar" required>
                                    <span class="batdata-check-box" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    <span class="batdata-check-text">Saya menyatakan bahwa seluruh data dan informasi yang disampaikan di atas adalah benar dan dapat dipertanggungjawabkan.</span>
                                </label>
                                <label class="batdata-check-item">
                                    <input type="checkbox" name="pernyataan_ketentuan" required>
                                    <span class="batdata-check-box" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                                    <span class="batdata-check-text">Saya bersedia mematuhi ketentuan penggunaan data yang berlaku di Balai Air Tanah.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="data-form-actions">
                    <div class="magang-action-btns">
                        <button type="button" id="btn-reset-form" class="magang-reset-btn">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset Form</span>
                        </button>
                        <button type="submit" class="magang-submit-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan</span>
                        </button>
                    </div>
                    <span class="magang-form-note">
                        <span class="req">*</span> Menandakan kolom wajib diisi.
                    </span>
                </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('batdata-isi-formulir-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        var formCard = document.getElementById('batdata-formulir');
        var isHidden = formCard.style.display === 'none';
        formCard.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    document.querySelectorAll('.batdata-dropzone input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var dropzone = this.closest('.batdata-dropzone');
            var tag = dropzone.querySelector('.file-name-tag');
            if (this.files && this.files.length > 0) {
                dropzone.style.borderColor = '#0047cc';
                dropzone.style.background = '#f4f8ff';
                if (tag) {
                    tag.innerHTML = '<i class="fa-solid fa-file-lines"></i> ' + this.files[0].name + ' <span class="remove-file-btn" title="Batal"><i class="fa-solid fa-xmark"></i></span>';
                    tag.style.display = 'inline-flex';
                    
                    var removeBtn = tag.querySelector('.remove-file-btn');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            input.value = ''; // clear selection
                            input.dispatchEvent(new Event('change'));
                        });
                    }
                }
            } else {
                dropzone.style.borderColor = '#dce7fb';
                dropzone.style.background = '#f9fbfd';
                if (tag) {
                    tag.innerHTML = '';
                    tag.style.display = 'none';
                }
            }
        });
    });
});
</script>
@endpush