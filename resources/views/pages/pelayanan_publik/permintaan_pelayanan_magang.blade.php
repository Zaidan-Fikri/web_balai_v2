@extends('master.app')

@section('title', 'Permohonan Magang / Kunjungan - Balai Air Tanah')

@push('styles')
<style>
    .magang-section {
        padding: 22px 0 48px;
        background: linear-gradient(180deg, #f6f9ff 0%, #ffffff 40%, #f4f7fb 100%);
    }

    /* ── Intro + Alur Layanan ───────────────────────────── */
    .magang-top-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 16px;
        align-items: stretch;
    }
    .magang-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10,38,71,.05), 0 14px 34px rgba(10,38,71,.07);
        padding: 24px 28px;
        transition: box-shadow .22s ease, transform .22s ease;
    }
    .magang-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .magang-card:hover {
        box-shadow: 0 4px 14px rgba(10,38,71,.07), 0 20px 44px rgba(10,38,71,.1);
    }
    .magang-kicker {
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
    .magang-kicker::before {
        content: '';
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .magang-intro { display: flex; flex-direction: column; gap: 12px; }
    .magang-intro-icon {
        position: relative;
        width: 66px; height: 66px;
        display: grid; place-items: center;
        border-radius: 18px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 26px;
        box-shadow: 0 14px 30px rgba(0,71,204,.28), 0 0 0 6px rgba(0,71,204,.06);
    }
    .magang-intro h2 {
        margin: 0 0 8px;
        color: var(--bat-primary-dark);
        font-size: 1.34rem;
        font-weight: 900;
        letter-spacing: -.01em;
    }
    .magang-intro p {
        margin: 0;
        color: #5f6c7b;
        font-size: .93rem;
        line-height: 1.8;
    }
    .magang-btn {
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
        cursor: pointer;
    }
    .magang-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0,42,140,.34), inset 0 1px 0 rgba(255,255,255,.18);
    }
    .magang-btn i:first-child { font-size: .8rem; }
    .magang-btn-arrow { font-size: .7rem; opacity: .85; transition: transform .2s ease; }
    .magang-btn:hover .magang-btn-arrow { transform: translateX(3px); }

    .magang-alur h3 {
        margin: 0 0 20px;
        color: var(--bat-primary-dark);
        font-size: 1.08rem;
        font-weight: 900;
    }
    .magang-alur-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
    }
    .magang-alur-step { text-align: center; position: relative; transition: transform .18s ease; }
    .magang-alur-step:hover { transform: translateY(-2px); }
    .magang-alur-step::after {
        content: '';
        position: absolute;
        top: 20px; right: -50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #a9c3ef, #d9e4f8);
        z-index: 0;
    }
    .magang-alur-step:last-child::after { display: none; }
    .magang-alur-icon-wrap {
        position: relative;
        width: 40px; height: 40px;
        margin: 0 auto 10px;
        z-index: 1;
    }
    .magang-alur-icon {
        width: 40px; height: 40px;
        display: grid; place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .9rem;
        box-shadow: 0 8px 18px rgba(0,71,204,.28), 0 0 0 4px #fff;
    }
    .magang-alur-step:last-child .magang-alur-icon {
        background: linear-gradient(135deg, #f0b429, #f6c34a);
        box-shadow: 0 8px 18px rgba(240,180,41,.35), 0 0 0 4px #fff;
    }
    .magang-alur-num {
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
    .magang-alur-step:last-child .magang-alur-num { background: #d89100; }
    .magang-alur-step strong {
        display: block;
        margin-bottom: 4px;
        color: var(--bat-primary-dark);
        font-size: .82rem;
        font-weight: 800;
    }
    .magang-alur-step span {
        display: block;
        color: #8290a3;
        font-size: .72rem;
        line-height: 1.55;
    }

    /* ── Persyaratan + Info Layanan ─────────────────────── */
    .magang-mid-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
        gap: 16px;
        margin-bottom: 16px;
        align-items: stretch;
    }
    .magang-mid-grid > .magang-card {
        display: flex;
        flex-direction: column;
    }
    .magang-card h3 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 18px;
        color: var(--bat-primary-dark);
        font-size: 1.05rem;
        font-weight: 900;
    }
    .magang-card h3 .magang-h-icon {
        width: 34px; height: 34px;
        display: grid; place-items: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .85rem;
        box-shadow: 0 8px 18px rgba(0,71,204,.22);
        flex-shrink: 0;
    }
    .magang-req-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .magang-req-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 13px;
        border: 1px solid #eef2f8;
        border-radius: 10px;
        background: linear-gradient(180deg, #fbfdff, #f6f9ff);
        color: #344054;
        font-size: .84rem;
        font-weight: 600;
        line-height: 1.4;
        transition: border-color .18s ease, transform .18s ease, box-shadow .18s ease;
    }
    .magang-req-list li:hover {
        border-color: #c8dcff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(10,38,71,.06);
    }
    .magang-req-list li i {
        width: 22px; height: 22px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        font-size: .62rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(22,163,74,.28);
    }

    .magang-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
    }
    .magang-info-item {
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
    .magang-info-item::before {
        content: '';
        position: absolute;
        left: 0; top: 10px; bottom: 10px;
        width: 3px;
        border-radius: 999px;
        background: linear-gradient(180deg, #0047cc, #16a3e8);
    }
    .magang-info-item-icon {
        width: 32px; height: 32px;
        display: grid; place-items: center;
        border-radius: 9px;
        background: #eef4ff;
        color: var(--bat-primary);
        font-size: .8rem;
        flex-shrink: 0;
    }
    .magang-info-item dt {
        color: #8290a3;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }
    .magang-info-item dd {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .86rem;
        font-weight: 700;
        line-height: 1.45;
    }
    .magang-info-item dd a { color: inherit; text-decoration: none; }
    .magang-info-item dd a:hover { color: #0047cc; }

    /* ── Formulir Permohonan ─────────────────────────────── */
    .magang-form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 4px 20px rgba(10,38,71,.06);
        padding: 26px 30px;
    }
    .magang-form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 2px dashed #e6ecf5;
        flex-wrap: wrap;
        gap: 12px;
    }
    .magang-form-header-title h3 {
        margin: 0 0 4px;
        color: var(--bat-primary-dark);
        font-size: 1.22rem;
        font-weight: 900;
    }
    .magang-form-header-title p {
        margin: 0;
        color: #7a8b9e;
        font-size: .88rem;
    }
    .magang-counter-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        background: #eef4ff;
        border: 1px solid #c8dcff;
        color: var(--bat-primary-dark);
        font-size: .84rem;
        font-weight: 800;
    }
    .magang-counter-badge i { color: #0047cc; }
    .magang-counter-badge strong {
        color: #0047cc;
        font-size: 1.05rem;
    }

    .magang-sections-four-col {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        align-items: start;
        margin-bottom: 20px;
    }
    .magang-form-section {
        margin-bottom: 0;
        padding: 20px;
        border-radius: 12px;
        background: #fbfcfe;
        border: 1px solid #edf2f9;
    }
    .magang-form-section:last-of-type { margin-bottom: 0; }
    .magang-section-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e6ecf5;
    }
    .magang-section-num {
        width: 26px; height: 26px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .78rem;
        font-weight: 900;
    }
    .magang-section-head h4 {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .98rem;
        font-weight: 900;
    }

    .magang-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .magang-field { margin-bottom: 14px; }
    .magang-field:last-child { margin-bottom: 0; }
    .magang-field label {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: .83rem;
        font-weight: 700;
    }
    .magang-field .req { color: #e11d48; margin-left: 2px; }
    .magang-field input[type="text"],
    .magang-field input[type="email"],
    .magang-field input[type="tel"],
    .magang-field input[type="date"],
    .magang-field textarea,
    .magang-field select {
        width: 100%;
        padding: 9px 13px;
        border: 1px solid #dde4ee;
        border-radius: 8px;
        background: #fff;
        color: #172335;
        font-size: .86rem;
        font-family: inherit;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .magang-field input:focus,
    .magang-field textarea:focus,
    .magang-field select:focus {
        outline: none;
        border-color: #0047cc;
        box-shadow: 0 0 0 3px rgba(0,71,204,.1);
    }
    .magang-field textarea { resize: vertical; min-height: 64px; }

    /* Dynamic Form Peserta */
    .peserta-list-wrap { display: grid; gap: 10px; margin-bottom: 12px; }
    .peserta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        animation: fadeInRow .22s ease-out;
    }
    @keyframes fadeInRow {
        from { opacity: 0; transform: translateY(-6px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .peserta-input-wrap { flex: 1; min-width: 0; }
    .peserta-input-wrap input { margin: 0; }
    .btn-peserta-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        border-radius: 8px;
        border: 1px solid #dde4ee;
        background: #fff;
        color: var(--bat-primary);
        font-size: .9rem;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease, color .15s ease, transform .15s ease;
    }
    .btn-peserta-icon:hover { transform: translateY(-1px); }
    .btn-peserta-add {
        border-style: dashed;
        background: #f0f5ff;
        border-color: #0047cc;
        color: #0047cc;
    }
    .btn-peserta-add:hover { background: #e1ecff; }
    .btn-peserta-remove {
        color: #e11d48;
        border-color: #fecdd3;
        background: #fff5f5;
    }
    .btn-peserta-remove:hover { background: #ffe4e6; border-color: #fda4af; }

    /* Checkboxes & Dropzones */
    .magang-checkbox-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 6px;
    }




    .magang-checkbox-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border: 1px solid #dde4ee;
        border-radius: 8px;
        background: #fff;
        font-size: .85rem;
        color: #344054;
        cursor: pointer;
        margin-bottom: 0;
    }
    .magang-checkbox-card input[type="checkbox"] {
        margin: 0;
        width: 16px;
        height: 16px;
        cursor: pointer;
        position: relative;
        top: 2px;
        transform: translateY(1px);
    }

    .magang-dropzone {
        position: relative;
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
    .magang-dropzone:hover { border-color: #7fa8f0; background: #f4f8ff; }
    .magang-dropzone.has-file { border-color: #0047cc; background: #f4f8ff; }
    .magang-dropzone i { font-size: 1.6rem; color: var(--bat-primary); margin-bottom: 4px; }
    .magang-dropzone strong { color: var(--bat-primary-dark); font-size: .86rem; }
    .magang-dropzone span { font-size: .74rem; }
    .magang-dropzone input[type="file"] { display: none; }
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

    /* Pernyataan & Actions */
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
    .magang-pernyataan-wrap {
        display: grid;
        gap: 10px;
        margin-top: 16px;
        padding: 16px 20px;
        border-radius: 12px;
        background: #fff8eb;
        border: 1px solid #fce8c3;
    }
    .magang-check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #475467;
        font-size: .85rem;
        line-height: 1.6;
        cursor: pointer;
    }
    .magang-check-item input {
        margin-top: 4px;
        width: 17px; height: 17px;
        accent-color: #0047cc;
        flex-shrink: 0;
    }

    .magang-form-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 10px;
    }
    .magang-action-btns { display: flex; gap: 12px; }
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
        box-shadow: 0 8px 20px rgba(0,71,204,.24);
    }
    .magang-submit-btn:hover {
        background: linear-gradient(135deg, #0036a3, #0a2456);
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(0,71,204,.32);
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
    .magang-form-note {
        flex-basis: 100%;
        color: #8290a3;
        font-size: .78rem;
        text-align: center;
    }

    @media (max-width: 1200px) {
        .magang-sections-four-col { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 991px) {
        .magang-mid-grid { grid-template-columns: 1fr; }
        .magang-alur-steps { grid-template-columns: repeat(3, minmax(0,1fr)); row-gap: 22px; }
        .magang-alur-step::after { display: none; }
    }
    @media (max-width: 620px) {
        .magang-req-list, .magang-info-grid, .magang-checkbox-grid { grid-template-columns: 1fr; }
        .magang-alur-steps { grid-template-columns: 1fr 1fr; }
        .magang-sections-four-col { grid-template-columns: 1fr; }
        .magang-form-actions { flex-direction: column; align-items: stretch; }
        .magang-action-btns { flex-direction: column; }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permohonan Magang / Kunjungan'])

<section class="magang-section">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <a href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">Pelayanan Publik</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Magang / Kunjungan</span>
        </nav>

        {{-- Intro + Alur Layanan --}}
        <div class="magang-top-grid">
            <div class="magang-card magang-intro">
                <div class="magang-intro-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div>
                    <span class="magang-kicker">Pelayanan Publik</span>
                    <h2>Permohonan Magang / Kunjungan</h2>
                    <p>Balai Air Tanah memberikan kesempatan kepada mahasiswa, siswa, akademisi, serta instansi/lembaga untuk melaksanakan kegiatan Magang, Praktik Kerja Lapangan (PKL), maupun Kunjungan Edukasi/Studi Banding di bidang pengelolaan dan teknologi air tanah.</p>
                </div>
                <a href="#magang-formulir" class="magang-btn" id="magang-isi-formulir-btn">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi Formulir Permohonan</span>
                    <i class="fa-solid fa-arrow-right magang-btn-arrow"></i>
                </a>
            </div>

            <div class="magang-card magang-alur">
                <h3><i class="fa-solid fa-diagram-project text-primary me-2"></i> Alur Layanan Magang / Kunjungan</h3>
                <div class="magang-alur-steps">
                    <div class="magang-alur-step">
                        <div class="magang-alur-icon-wrap">
                            <div class="magang-alur-icon"><i class="fa-solid fa-file-pen"></i></div>
                            <span class="magang-alur-num">1</span>
                        </div>
                        <strong>Isi Formulir</strong>
                        <span>Lengkapi formulir permohonan kegiatan.</span>
                    </div>
                    <div class="magang-alur-step">
                        <div class="magang-alur-icon-wrap">
                            <div class="magang-alur-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                            <span class="magang-alur-num">2</span>
                        </div>
                        <strong>Verifikasi</strong>
                        <span>Verifikasi kelengkapan data oleh petugas.</span>
                    </div>
                    <div class="magang-alur-step">
                        <div class="magang-alur-icon-wrap">
                            <div class="magang-alur-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            <span class="magang-alur-num">3</span>
                        </div>
                        <strong>Koordinasi Jadwal</strong>
                        <span>Koordinasi jadwal kegiatan bersama pemohon.</span>
                    </div>
                    <div class="magang-alur-step">
                        <div class="magang-alur-icon-wrap">
                            <div class="magang-alur-icon"><i class="fa-solid fa-list-check"></i></div>
                            <span class="magang-alur-num">4</span>
                        </div>
                        <strong>Persetujuan</strong>
                        <span>Persetujuan kegiatan oleh pihak balai.</span>
                    </div>
                    <div class="magang-alur-step">
                        <div class="magang-alur-icon-wrap">
                            <div class="magang-alur-icon"><i class="fa-solid fa-flag-checkered"></i></div>
                            <span class="magang-alur-num">5</span>
                        </div>
                        <strong>Pelaksanaan Kegiatan</strong>
                        <span>Pelaksanaan kegiatan sesuai jadwal yang disepakati.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Persyaratan + Info Layanan --}}
        <div class="magang-mid-grid">
            <div class="magang-card">
                <h3>
                    <span class="magang-h-icon"><i class="fa-solid fa-list-check"></i></span>
                    Persyaratan Permohonan
                </h3>
                <ul class="magang-req-list">
                    <li><i class="fa-solid fa-check"></i> Surat Permohonan Resmi dari Kampus/Sekolah/Instansi</li>
                    <li><i class="fa-solid fa-check"></i> Proposal / Kerangka Kegiatan Magang atau Kunjungan</li>
                    <li><i class="fa-solid fa-check"></i> Daftar Peserta (Nama, NIM/NIS, & Jurusan/Program Studi)</li>
                    <li><i class="fa-solid fa-check"></i> Kartu Identitas (KTM / KTP / Kartu Pelajar)</li>
                    <li><i class="fa-solid fa-check"></i> Mematuhi Peraturan & Protokol K3 Balai Air Tanah</li>
                    <li><i class="fa-solid fa-check"></i> Menyusun & Menyerahkan Laporan Akhir (Khusus Magang)</li>
                </ul>
            </div>

            <div class="magang-card">
                <h3>
                    <span class="magang-h-icon"><i class="fa-solid fa-circle-info"></i></span>
                    Informasi Layanan
                </h3>
                <dl class="magang-info-grid">
                    <div class="magang-info-item">
                        <div class="magang-info-item-icon"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <dt>Waktu Pelayanan</dt>
                            <dd>Senin – Jumat<br>07.30 – 16.00 WIB</dd>
                        </div>
                    </div>
                    <div class="magang-info-item">
                        <div class="magang-info-item-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <div>
                            <dt>Durasi Layanan</dt>
                            <dd>Magang: 1–3 Bulan<br>Kunjungan: 1 Hari</dd>
                        </div>
                    </div>
                    <div class="magang-info-item">
                        <div class="magang-info-item-icon"><i class="fa-solid fa-tag"></i></div>
                        <div>
                            <dt>Biaya Layanan</dt>
                            <dd>Rp 0,- (Gratis / Tidak Dipungut Biaya)</dd>
                        </div>
                    </div>
                    <div class="magang-info-item">
                        <div class="magang-info-item-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <dt>Lokasi Balai</dt>
                            <dd>Jl. Ir. H. Juanda No. 193, Bandung, Jawa Barat</dd>
                        </div>
                    </div>
                    
                </dl>
            </div>
        </div>

        {{-- Formulir Permohonan --}}
        <div class="magang-form-card" id="magang-formulir" style="display: none;">
            <div class="magang-form-header">
                <div class="magang-form-header-title">
                    <h3>Formulir Permohonan Magang / Kunjungan</h3>
                    <p>Silakan isi data dengan lengkap dan benar untuk memproses pengajuan Anda.</p>
                </div>
                <div class="magang-counter-badge">
                    <i class="fa-solid fa-users"></i>
                    <span>Total Peserta:</span>
                    <strong id="total-peserta-count">1</strong>
                    <span>orang</span>
                </div>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" id="form-magang-kunjungan">
                @csrf

                <div class="magang-sections-four-col">
                    {{-- 1. Data Peserta --}}
                    <div class="magang-form-section">
                        <div class="magang-section-head">
                            <span class="magang-section-num">1</span>
                            <h4>Data Peserta</h4>
                        </div>

                        <div class="magang-field">
                            <label>Nama Peserta <span class="req">*</span></label>
                            <div class="peserta-list-wrap" id="peserta-container">
                                <div class="peserta-item" data-index="1">
                                    <div class="peserta-input-wrap">
                                        <input type="text" name="nama_peserta[]" placeholder="Masukkan nama lengkap peserta" required>
                                    </div>
                                    <button type="button" class="btn-peserta-icon btn-peserta-add" title="Tambah peserta">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="magang-form-grid" style="margin-top: 14px;">
                            <div class="magang-field">
                                <label>Instansi / Sekolah / Kampus <span class="req">*</span></label>
                                <input type="text" name="instansi" placeholder="Contoh: Universitas Gadjah Mada / SMKN 1 Bandung" required>
                            </div>

                            <div class="magang-field">
                                <label>Jabatan / Status Peserta <span class="req">*</span></label>
                                <select name="jabatan_status" required>
                                    <option value="" selected disabled>Pilih jabatan / status</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Siswa SMK/SMA">Siswa SMK / SMA</option>
                                    <option value="Dosen/Pengajar">Dosen / Tenaga Pendidik</option>
                                    <option value="Staf Instansi">Staf / Pegawai Instansi</option>
                                    <option value="Peneliti">Peneliti</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="magang-field">
                                <label>Nomor Telepon / WhatsApp <span class="req">*</span></label>
                                <input type="tel" name="telepon" placeholder="Contoh: 081234567890" required>
                            </div>

                            <div class="magang-field">
                                <label>Email Peserta / Instansi <span class="req">*</span></label>
                                <input type="email" name="email" placeholder="Contoh: nama@instansi.ac.id" required>
                            </div>
                        </div>

                        <div class="magang-field" style="margin-top: 14px;">
                            <label>Alamat Instansi / Sekolah / Kampus <span class="req">*</span></label>
                            <textarea name="alamat_instansi" rows="2" placeholder="Masukkan alamat lengkap instansi/sekolah/kampus" required></textarea>
                        </div>
                    </div>

                        {{-- 2. Jenis Permohonan --}}
                        <div class="magang-form-section">
                            <div class="magang-section-head">
                                <span class="magang-section-num">2</span>
                                <h4>Jenis Permohonan</h4>
                            </div>

                            <div class="magang-form-grid">
                                <div class="magang-field">
                                    <label>Jenis Permohonan <span class="req">*</span></label>
                                    <select name="jenis_permohonan" id="jenis_permohonan" required>
                                        <option value="" selected disabled>Pilih jenis permohonan</option>
                                        <option value="Magang">Magang / Kerja Praktik (PKL)</option>
                                        <option value="Kunjungan">Kunjungan Lapangan / Edukasi / Studi Banding</option>
                                    </select>
                                </div>

                                <div class="magang-field">
                                    <label>Nama Kegiatan <span class="req">*</span></label>
                                    <input type="text" name="nama_kegiatan" placeholder="Contoh: Praktik Kerja Lapangan Hidrogeologi Semester Genap" required>
                                </div>
                            </div>

                            <div class="magang-field" style="margin-top: 14px;">
                                <label>Tujuan Kegiatan <span class="req">*</span></label>
                                <textarea name="tujuan_kegiatan" rows="2" placeholder="Jelaskan tujuan dan sasaran utama pelaksanaan kegiatan" required></textarea>
                            </div>

                            <div class="magang-field" style="margin-top: 14px;">
                                <label>Topik yang Ingin Dipelajari <span class="req">*</span></label>
                                <textarea name="topik_dipelajari" rows="2" placeholder="Contoh: Pemetaan Hidrogeologi, Pengujian Sampel Kualitas Air, Geolistrik 1D/2D, Manajemen Database Air Tanah" required></textarea>
                            </div>
                        </div>

                        {{-- 3. Detail Kegiatan --}}
                        <div class="magang-form-section">
                            <div class="magang-section-head">
                                <span class="magang-section-num">3</span>
                                <h4>Detail Kegiatan</h4>
                            </div>

                            <div class="magang-form-grid">
                                <div class="magang-field">
                                    <label>Tanggal Mulai Kegiatan <span class="req">*</span></label>
                                    <input type="date" name="tanggal_mulai" required title="Tanggal Mulai Kegiatan">
                                </div>

                                
                            </div>

                            <div class="magang-field" style="margin-top: 14px;">
                                <label>Durasi Kegiatan <span class="req">*</span></label>
                                <input type="text" name="durasi_kegiatan" placeholder="Contoh: 1 Bulan / 2 Minggu / 1 Hari" required>
                            </div>

                            <div class="magang-field" style="margin-top: 14px;">
                                <label>Kebutuhan Kegiatan <span class="req">*</span></label>
                                <div class="magang-checkbox-grid">
                                    <label class="magang-checkbox-card">
                                        <input type="checkbox" name="kebutuhan[]" value="Pengenalan Profil Balai">
                                        <span>Pengenalan Profil Balai</span>
                                    </label>

                                    <label class="magang-checkbox-card">
                                        <input type="checkbox" name="kebutuhan[]" value="Materi Air Tanah">
                                        <span>Materi Air Tanah</span>
                                    </label>

                                    <label class="magang-checkbox-card">
                                        <input type="checkbox" name="kebutuhan[]" value="Kunjungan Laboratorium">
                                        <span>Kunjungan Laboratorium</span>
                                    </label>

                                    <label class="magang-checkbox-card">
                                        <input type="checkbox" name="kebutuhan[]" value="Diskusi Teknis">
                                        <span>Diskusi Teknis</span>
                                    </label>

                                    <label class="magang-checkbox-card">
                                        <input type="checkbox" name="kebutuhan[]" value="Lainnya" id="cb-kebutuhan-lainnya">
                                        <span>Lainnya</span>
                                    </label>
                                </div>
                                <div id="field-kebutuhan-lainnya" style="display: none; margin-top: 10px;">
                                    <input type="text" name="kebutuhan_lainnya" placeholder="Sebutkan kebutuhan kegiatan lainnya">
                                </div>
                            </div>
                        </div>

                        {{-- 4. Bagian Lampiran + Pernyataan --}}
                        <div>
                            <div class="magang-form-section">
                                <div class="magang-section-head">
                                    <span class="magang-section-num">4</span>
                                    <h4>Bagian Lampiran Dokumen</h4>
                                </div>

                                <div class="magang-field">
                                    <label>Unggah Dokumen Pendukung (Compile dalam 1 File) <span class="req">*</span></label>
                                </div>

                                <label class="magang-dropzone">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <strong>Seret dan lepas file di sini</strong>
                                    <span>atau klik untuk memilih file</span>
                                    <span>Format: PDF, ZIP, RAR (Maks. 10MB)</span>
                                    <input type="file" name="lampiran_dokumen" accept=".pdf,.zip,.rar" required>
                                    <span class="file-name-tag"></span>
                                </label>
                            </div>

                            <div class="magang-form-section">
                                <div class="magang-section-head">
                                    <span class="magang-section-num">5</span>
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
                                    <span class="batdata-check-text">Saya menyatakan bersedia menaati peraturan dan ketentuan yang berlaku di Balai Air Tanah selama pelaksanaan kegiatan.</span>
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>

                {{-- Tombol Aksi --}}
                <div class="magang-form-actions">
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
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('magang-isi-formulir-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        var formCard = document.getElementById('magang-formulir');
        var isHidden = formCard.style.display === 'none';
        formCard.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    var container = document.getElementById('peserta-container');
    var totalCountEl = document.getElementById('total-peserta-count');
    var cbLainnya = document.getElementById('cb-kebutuhan-lainnya');
    var fieldLainnya = document.getElementById('field-kebutuhan-lainnya');
    var btnReset = document.getElementById('btn-reset-form');
    var form = document.getElementById('form-magang-kunjungan');

    // Update Live Count
    function updateTotalPeserta() {
        var items = container.querySelectorAll('.peserta-item');
        totalCountEl.textContent = items.length;

        items.forEach(function(item, idx) {
            item.setAttribute('data-index', idx + 1);
        });
    }

    // Bind a "+" add button on a row
    function bindAddButton(addBtn) {
        if (!addBtn || addBtn.dataset.bound) return;
        addBtn.dataset.bound = 'true';
        addBtn.addEventListener('click', function() {
            var nextNum = container.querySelectorAll('.peserta-item').length + 1;

            var newItem = document.createElement('div');
            newItem.className = 'peserta-item';
            newItem.setAttribute('data-index', nextNum);
            newItem.innerHTML = `
                <div class="peserta-input-wrap">
                    <input type="text" name="nama_peserta[]" placeholder="Masukkan nama lengkap peserta" required>
                </div>
                <button type="button" class="btn-peserta-icon btn-peserta-remove" title="Hapus peserta">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            bindRemoveButton(newItem.querySelector('.btn-peserta-remove'));

            container.appendChild(newItem);
            updateTotalPeserta();

            var newInput = newItem.querySelector('input');
            if (newInput) newInput.focus();
        });
    }

    // Bind a "x" remove button on a row
    function bindRemoveButton(removeBtn) {
        if (!removeBtn || removeBtn.dataset.bound) return;
        removeBtn.dataset.bound = 'true';
        removeBtn.addEventListener('click', function() {
            var item = removeBtn.closest('.peserta-item');
            if (item) item.remove();
            updateTotalPeserta();
        });
    }

    // Bind initial rows
    container.querySelectorAll('.peserta-item').forEach(function(item) {
        bindAddButton(item.querySelector('.btn-peserta-add'));
        bindRemoveButton(item.querySelector('.btn-peserta-remove'));
    });

    // Checkbox Kebutuhan Lainnya Toggle
    cbLainnya?.addEventListener('change', function() {
        fieldLainnya.style.display = this.checked ? 'block' : 'none';
        var inputLainnya = fieldLainnya.querySelector('input');
        if (this.checked && inputLainnya) {
            inputLainnya.focus();
            inputLainnya.required = true;
        } else if (inputLainnya) {
            inputLainnya.required = false;
            inputLainnya.value = '';
        }
    });

    // File Input Dropzone Labeling
    document.querySelectorAll('.magang-dropzone input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var dropzone = this.closest('.magang-dropzone');
            var tag = dropzone.querySelector('.file-name-tag');
            if (this.files && this.files.length > 0) {
                dropzone.classList.add('has-file');
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
                dropzone.classList.remove('has-file');
                if (tag) {
                    tag.innerHTML = '';
                    tag.style.display = 'none';
                }
            }
        });
    });

    // Reset Form Listener
    btnReset?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh isian formulir?')) {
            form.reset();
            
            // Reset dynamic peserta list back to 1
            var items = container.querySelectorAll('.peserta-item');
            items.forEach(function(item, idx) {
                if (idx > 0) item.remove();
            });
            
            // Hide kebutuhan lainnya
            if (fieldLainnya) fieldLainnya.style.display = 'none';

            // Reset dropzone file tags
            document.querySelectorAll('.magang-dropzone').forEach(function(dz) {
                dz.classList.remove('has-file');
                var tag = dz.querySelector('.file-name-tag');
                if (tag) {
                    tag.innerHTML = '';
                    tag.style.display = 'none';
                }
            });

            updateTotalPeserta();
        }
    });

    // Form Submit Event Handler
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Terima kasih! Permohonan Magang / Kunjungan Anda telah berhasil terkirim. Petugas Balai Air Tanah akan memverifikasi dan menghubungi Anda melalui Email / WhatsApp.');
    });

    // Initialize total counter
    updateTotalPeserta();
});
</script>
@endpush
@endsection
