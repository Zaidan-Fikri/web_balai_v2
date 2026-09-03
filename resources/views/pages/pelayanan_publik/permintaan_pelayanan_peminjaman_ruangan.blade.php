@extends('master.app')

@section('title', 'Peminjaman Ruangan - Balai Air Tanah')

@push('styles')
<style>
    .peminjaman-section {
        padding: 22px 0 48px;
        background: linear-gradient(180deg, #f6f9ff 0%, #ffffff 40%, #f4f7fb 100%);
    }

    /* ── Intro + Alur Layanan ───────────────────────────── */
    .peminjaman-top-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 16px;
        align-items: stretch;
    }
    .peminjaman-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10,38,71,.05), 0 14px 34px rgba(10,38,71,.07);
        padding: 24px 28px;
        transition: box-shadow .22s ease, transform .22s ease;
    }
    .peminjaman-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }
    .peminjaman-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 14px rgba(10,38,71,.07), 0 22px 48px rgba(10,38,71,.12);
    }
    .peminjaman-kicker {
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
    .peminjaman-kicker::before {
        content: '';
        width: 24px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }
    .peminjaman-intro { display: flex; flex-direction: column; gap: 12px; }
    .peminjaman-intro-icon {
        position: relative;
        width: 66px; height: 66px;
        display: grid; place-items: center;
        border-radius: 18px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: 26px;
        box-shadow: 0 14px 30px rgba(0,71,204,.28), 0 0 0 6px rgba(0,71,204,.06);
    }
    .peminjaman-intro h2 {
        margin: 0 0 8px;
        color: var(--bat-primary-dark);
        font-size: 1.34rem;
        font-weight: 900;
        letter-spacing: -.01em;
    }
    .peminjaman-intro p {
        margin: 0;
        color: #5f6c7b;
        font-size: .93rem;
        line-height: 1.8;
    }
    .peminjaman-btn {
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
    .peminjaman-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0,42,140,.34), inset 0 1px 0 rgba(255,255,255,.18);
    }
    .peminjaman-btn i:first-child { font-size: .8rem; }
    .peminjaman-btn-arrow { font-size: .7rem; opacity: .85; transition: transform .2s ease; }
    .peminjaman-btn:hover .peminjaman-btn-arrow { transform: translateX(3px); }

    .peminjaman-alur h3 {
        margin: 0 0 20px;
        color: var(--bat-primary-dark);
        font-size: 1.08rem;
        font-weight: 900;
    }
    .peminjaman-alur-steps {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 8px;
    }
    .peminjaman-alur-step { text-align: center; position: relative; transition: transform .18s ease; }
    .peminjaman-alur-step:hover { transform: translateY(-2px); }
    .peminjaman-alur-step::after {
        content: '';
        position: absolute;
        top: 20px; right: -50%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #a9c3ef, #d9e4f8);
        z-index: 0;
    }
    .peminjaman-alur-step:last-child::after { display: none; }
    .peminjaman-alur-icon-wrap {
        position: relative;
        width: 40px; height: 40px;
        margin: 0 auto 10px;
        z-index: 1;
    }
    .peminjaman-alur-icon {
        width: 40px; height: 40px;
        display: grid; place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .9rem;
        box-shadow: 0 8px 18px rgba(0,71,204,.28), 0 0 0 4px #fff;
    }
    .peminjaman-alur-num {
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
    .peminjaman-alur-step strong {
        display: block;
        margin-bottom: 4px;
        color: var(--bat-primary-dark);
        font-size: .82rem;
        font-weight: 800;
    }
    .peminjaman-alur-step span {
        display: block;
        color: #8290a3;
        font-size: .72rem;
        line-height: 1.55;
    }

    /* ── Persyaratan + Info Layanan ─────────────────────── */
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
    .peminjaman-mid-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
        gap: 16px;
        margin-bottom: 16px;
        align-items: stretch;
    }
    .peminjaman-mid-grid > .peminjaman-card {
        display: flex;
        flex-direction: column;
    }
    .peminjaman-card h3 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 18px;
        color: var(--bat-primary-dark);
        font-size: 1.05rem;
        font-weight: 900;
    }
    .peminjaman-card h3 .peminjaman-h-icon {
        width: 34px; height: 34px;
        display: grid; place-items: center;
        border-radius: 10px;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .85rem;
        box-shadow: 0 8px 18px rgba(0,71,204,.22);
        flex-shrink: 0;
    }
    .peminjaman-req-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: start;
        gap: 10px;
        flex: 1;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .peminjaman-req-list li {
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
    .peminjaman-req-list li:hover {
        border-color: #c8dcff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(10,38,71,.06);
    }
    .peminjaman-req-list li i {
        width: 22px; height: 22px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        font-size: .62rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(22,163,74,.28);
    }
    .peminjaman-req-note {
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
    .peminjaman-req-note i { margin-top: 2px; color: #d97706; flex-shrink: 0; }

    .peminjaman-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-content: center;
        gap: 10px;
        flex: 1;
        margin: 0;
    }
    .peminjaman-info-item {
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
    .peminjaman-info-item::before {
        content: '';
        position: absolute;
        left: 0; top: 10px; bottom: 10px;
        width: 3px;
        border-radius: 999px;
        background: linear-gradient(180deg, #0047cc, #16a3e8);
    }
    .peminjaman-info-item-icon {
        width: 32px; height: 32px;
        display: grid; place-items: center;
        border-radius: 9px;
        background: #eef4ff;
        color: var(--bat-primary);
        font-size: .8rem;
        flex-shrink: 0;
    }
    .peminjaman-info-item dt {
        color: #8290a3;
        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }
    .peminjaman-info-item dd {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .86rem;
        font-weight: 700;
        line-height: 1.45;
    }
    .peminjaman-info-item dd a { color: inherit; text-decoration: none; }
    .peminjaman-info-item dd a:hover { color: #0047cc; }

    /* ── Formulir Permohonan ─────────────────────────────── */
    .peminjaman-form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 4px 20px rgba(10,38,71,.06);
        padding: 26px 30px;
        margin-bottom: 24px;
    }
    .peminjaman-form-header {
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 2px dashed #e6ecf5;
    }
    .peminjaman-form-header h3 {
        margin: 0 0 4px;
        color: var(--bat-primary-dark);
        font-size: 1.22rem;
        font-weight: 900;
    }
    .peminjaman-form-header p {
        margin: 0;
        color: #7a8b9e;
        font-size: .88rem;
    }

    .peminjaman-sections-four-col {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        align-items: start;
        margin-bottom: 20px;
    }
    .peminjaman-form-section {
        margin-bottom: 0;
        padding: 20px;
        border-radius: 12px;
        background: #fbfcfe;
        border: 1px solid #edf2f9;
    }
    .peminjaman-form-section:last-of-type { margin-bottom: 0; }
    .peminjaman-section-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e6ecf5;
    }
    .peminjaman-section-num {
        width: 26px; height: 26px;
        display: grid; place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #0047cc, #16a3e8);
        color: #fff;
        font-size: .78rem;
        font-weight: 900;
    }
    .peminjaman-section-head h4 {
        margin: 0;
        color: var(--bat-primary-dark);
        font-size: .98rem;
        font-weight: 900;
    }

    .peminjaman-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .peminjaman-form-grid-two {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .peminjaman-field { margin-bottom: 14px; }
    .peminjaman-field:last-child { margin-bottom: 0; }
    .peminjaman-field label {
        display: block;
        margin-bottom: 6px;
        color: #344054;
        font-size: .83rem;
        font-weight: 700;
    }
    .peminjaman-field .req { color: #e11d48; margin-left: 2px; }
    .peminjaman-field input[type="text"],
    .peminjaman-field input[type="email"],
    .peminjaman-field input[type="tel"],
    .peminjaman-field input[type="date"],
    .peminjaman-field input[type="time"],
    .peminjaman-field input[type="number"],
    .peminjaman-field textarea,
    .peminjaman-field select {
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
    .peminjaman-field input:focus,
    .peminjaman-field textarea:focus,
    .peminjaman-field select:focus {
        outline: none;
        border-color: #0047cc;
        box-shadow: 0 0 0 3px rgba(0,71,204,.1);
    }
    .peminjaman-field textarea { resize: vertical; min-height: 64px; }

    /* Capacity Alert Box */
    .capacity-info-box {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: .84rem;
        font-weight: 700;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
    }
    .capacity-info-box.info {
        background: #eef4ff;
        border: 1px solid #c8dcff;
        color: var(--bat-primary-dark);
    }
    .capacity-info-box.warning {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #be123c;
    }
    .capacity-info-box i { font-size: 1.1rem; flex-shrink: 0; }

    /* Dropzones */
    .peminjaman-dropzone {
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
    .peminjaman-dropzone:hover { border-color: #7fa8f0; background: #f4f8ff; }
    .peminjaman-dropzone.has-file { border-color: #0047cc; background: #f4f8ff; }
    .peminjaman-dropzone i { font-size: 1.6rem; color: var(--bat-primary); margin-bottom: 4px; }
    .peminjaman-dropzone strong { color: var(--bat-primary-dark); font-size: .86rem; }
    .peminjaman-dropzone span { font-size: .74rem; }
    .peminjaman-dropzone input[type="file"] { display: none; }
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
    .peminjaman-pernyataan-wrap {
        display: grid;
        gap: 10px;
        margin-top: 16px;
        padding: 16px 20px;
        border-radius: 12px;
        background: #fff8eb;
        border: 1px solid #fce8c3;
    }
    .peminjaman-check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #475467;
        font-size: .85rem;
        line-height: 1.6;
        cursor: pointer;
    }
    .peminjaman-check-item input {
        margin-top: 4px;
        width: 17px; height: 17px;
        accent-color: #0047cc;
        flex-shrink: 0;
    }

    .peminjaman-form-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 10px;
    }
    .peminjaman-action-btns { display: flex; gap: 12px; }
    .peminjaman-submit-btn,
    .peminjaman-reset-btn {
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
    .peminjaman-submit-btn {
        border: 0;
        background: linear-gradient(135deg, #0047cc, #123a8c);
        color: #fff;
        box-shadow: 0 8px 20px rgba(0,71,204,.24);
    }
    .peminjaman-submit-btn:hover {
        background: linear-gradient(135deg, #0036a3, #0a2456);
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(0,71,204,.32);
    }
    .peminjaman-reset-btn {
        border: 1px solid #dde4ee;
        background: #fff;
        color: #475467;
    }
    .peminjaman-reset-btn:hover {
        background: #f4f6f9;
        color: #172335;
    }
    .peminjaman-form-note {
        flex-basis: 100%;
        color: #8290a3;
        font-size: .78rem;
        text-align: center;
    }

    /* ── Section Butuh Bantuan? ─────────────────────────── */
    .help-section-card {
        background: linear-gradient(135deg, #003bab 0%, #0047cc 50%, #16a3e8 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(0,71,204,.25);
    }
    .help-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }
    .help-icon-wrap {
        width: 48px; height: 48px;
        display: grid; place-items: center;
        border-radius: 14px;
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(6px);
        color: #fff;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .help-header h3 {
        margin: 0 0 4px;
        font-size: 1.25rem;
        font-weight: 900;
        color: #fff;
    }
    .help-header p {
        margin: 0;
        font-size: .88rem;
        opacity: .9;
    }
    .help-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }
    .help-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,.18);
        transition: background .18s ease, transform .18s ease;
    }
    .help-item:hover {
        background: rgba(255,255,255,.2);
        transform: translateY(-2px);
    }
    .help-item-icon {
        width: 36px; height: 36px;
        display: grid; place-items: center;
        border-radius: 10px;
        background: #fff;
        color: #0047cc;
        font-size: .92rem;
        flex-shrink: 0;
    }
    .help-item dt {
        font-size: .7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        opacity: .85;
        margin-bottom: 2px;
    }
    .help-item dd {
        margin: 0;
        font-size: .88rem;
        font-weight: 800;
    }
    .help-item dd a { color: #fff; text-decoration: none; }
    .help-item dd a:hover { text-decoration: underline; }

    @media (max-width: 1200px) {
        .peminjaman-sections-four-col { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 991px) {
        .peminjaman-mid-grid, .help-grid { grid-template-columns: 1fr; }
        .peminjaman-alur-steps { grid-template-columns: repeat(3, minmax(0,1fr)); row-gap: 22px; }
        .peminjaman-alur-step::after { display: none; }
    }
    @media (max-width: 620px) {
        .peminjaman-req-list, .peminjaman-info-grid { grid-template-columns: 1fr; }
        .peminjaman-alur-steps { grid-template-columns: 1fr 1fr; }
        .peminjaman-sections-four-col { grid-template-columns: 1fr; }
        .peminjaman-form-actions { flex-direction: column; align-items: stretch; }
        .peminjaman-action-btns { flex-direction: column; }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Peminjaman Ruangan'])

<section class="peminjaman-section">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span>Pelayanan Publik</span>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Peminjaman Ruangan</span>
        </nav>

        {{-- Intro + Alur Layanan --}}
        <div class="peminjaman-top-grid">
            <div class="peminjaman-card peminjaman-intro wow fadeInDown" data-wow-delay="0.05s">
                <div class="peminjaman-intro-icon"><i class="fa-solid fa-building-user"></i></div>
                <div>
                    <span class="peminjaman-kicker">Pelayanan Publik</span>
                    <h2>Informasi Peminjaman Ruangan</h2>
                    <p>Balai Air Tanah menyediakan fasilitas peminjaman ruangan rapat dan sarana diskusi bagi instansi, akademisi, serta publik untuk mendukung kegiatan pertemuan teknis, audiensi, maupun pelatihan seputar pengelolaan air tanah.</p>
                </div>
                <a href="#peminjaman-formulir" class="peminjaman-btn" id="peminjaman-isi-formulir-btn">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi Formulir Permohonan</span>
                    <i class="fa-solid fa-arrow-right peminjaman-btn-arrow"></i>
                </a>
            </div>

            <div class="peminjaman-card peminjaman-alur wow fadeInUp" data-wow-delay="0.15s">
                <h3><i class="fa-solid fa-diagram-project text-primary me-2"></i> Alur Layanan Peminjaman Ruangan</h3>
                <div class="peminjaman-alur-steps">
                    <div class="peminjaman-alur-step">
                        <div class="peminjaman-alur-icon-wrap">
                            <div class="peminjaman-alur-icon"><i class="fa-solid fa-file-pen"></i></div>
                            <span class="peminjaman-alur-num">1</span>
                        </div>
                        <strong>Isi Formulir</strong>
                        <span>Lengkapi formulir permohonan kegiatan</span>
                    </div>
                    <div class="peminjaman-alur-step">
                        <div class="peminjaman-alur-icon-wrap">
                            <div class="peminjaman-alur-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                            <span class="peminjaman-alur-num">2</span>
                        </div>
                        <strong>Verifikasi</strong>
                        <span>Verifikasi kelengkapan data oleh petugas</span>
                    </div>
                    <div class="peminjaman-alur-step">
                        <div class="peminjaman-alur-icon-wrap">
                            <div class="peminjaman-alur-icon"><i class="fa-solid fa-door-open"></i></div>
                            <span class="peminjaman-alur-num">3</span>
                        </div>
                        <strong>Cek Ketersediaan</strong>
                        <span>Pengecekan ketersediaan ruangan dan fasilitas</span>
                    </div>
                    <div class="peminjaman-alur-step">
                        <div class="peminjaman-alur-icon-wrap">
                            <div class="peminjaman-alur-icon"><i class="fa-solid fa-list-check"></i></div>
                            <span class="peminjaman-alur-num">4</span>
                        </div>
                        <strong>Persetujuan</strong>
                        <span>Persetujuan penggunaan ruangan</span>
                    </div>
                    <div class="peminjaman-alur-step">
                        <div class="peminjaman-alur-icon-wrap">
                            <div class="peminjaman-alur-icon"><i class="fa-solid fa-flag-checkered"></i></div>
                            <span class="peminjaman-alur-num">5</span>
                        </div>
                        <strong>Pelaksanaan</strong>
                        <span>Penggunaan ruangan sesuai jadwal yang disepakati</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Persyaratan + Info Layanan --}}
        <div class="peminjaman-mid-grid">
            <div class="peminjaman-card wow fadeInLeft" data-wow-delay="0.2s">
                <h3>
                    <span class="peminjaman-h-icon"><i class="fa-solid fa-list-check"></i></span>
                    Persyaratan Permohonan
                </h3>
                <ul class="peminjaman-req-list">
                    <li><i class="fa-solid fa-check"></i> Surat Permohonan Resmi Peminjaman Ruangan</li>
                    <li><i class="fa-solid fa-check"></i> Rundown / Susunan Acara Kegiatan</li>
                    <li><i class="fa-solid fa-check"></i> Daftar Peserta & Penanggung Jawab Kegiatan</li>
                    <li><i class="fa-solid fa-check"></i> Mematuhi Kapasitas Maksimal Ruangan</li>
                    <li><i class="fa-solid fa-check"></i> Menjaga Kebersihan, Ketertiban, & Fasilitas</li>
                    <li><i class="fa-solid fa-check"></i> Mematuhi Ketentuan K3 & Dilarang Merokok</li>
                </ul>
                <div class="peminjaman-req-note">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Peminjaman ruangan bergantung pada ketersediaan jadwal. Pengajuan minimal 3 hari kerja sebelum tanggal kegiatan.</span>
                </div>
            </div>

            <div class="peminjaman-card wow fadeInRight" data-wow-delay="0.3s">
                <h3>
                    <span class="peminjaman-h-icon"><i class="fa-solid fa-circle-info"></i></span>
                    Informasi Layanan
                </h3>
                <dl class="peminjaman-info-grid">
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div>
                            <dt>Biaya</dt>
                            <dd>Tidak dipungut biaya</dd>
                        </div>
                    </div>
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <div>
                            <dt>Waktu Layanan</dt>
                            <dd>Senin&ndash;Jumat</dd>
                        </div>
                    </div>
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-regular fa-clock"></i></div>
                        <div>
                            <dt>Jam Layanan</dt>
                            <dd>07.30&ndash;16.00 WIB</dd>
                        </div>
                    </div>
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <dt>Telepon</dt>
                            <dd>(022) 20463967</dd>
                        </div>
                    </div>
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <dt>Email</dt>
                            <dd><a href="mailto:balaiirtanah@pu.go.id">balaiirtanah@pu.go.id</a></dd>
                        </div>
                    </div>
                    <div class="peminjaman-info-item">
                        <div class="peminjaman-info-item-icon"><i class="fa-solid fa-note-sticky"></i></div>
                        <div>
                            <dt>Catatan</dt>
                            <dd>Jadwal kegiatan disesuaikan dengan ketersediaan waktu &amp; kapasitas layanan</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Formulir Permohonan --}}
        <div class="peminjaman-form-card" id="peminjaman-formulir" style="display: none;">
            <div class="peminjaman-form-header">
                <h3>Formulir Permohonan Peminjaman Ruangan</h3>
                <p>Isi formulir berikut untuk mengajukan peminjaman ruangan di lingkungan Balai Air Tanah.</p>
            </div>

            <div class="peminjaman-sections-four-col">
                {{-- 1. Data Pemohon --}}
                    <div class="peminjaman-form-section">
                        <div class="peminjaman-section-head">
                            <span class="peminjaman-section-num">1</span>
                            <h4>Data Pemohon</h4>
                        </div>

                        <div class="peminjaman-field">
                            <label>Nama Penanggung Jawab <span class="req">*</span></label>
                            <input type="text" name="nama_pemohon" placeholder="Masukkan nama lengkap penanggung jawab" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Instansi / Perorangan <span class="req">*</span></label>
                            <input type="text" name="instansi" placeholder="Contoh: Dinas PU / Universitas / Perorangan" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Jabatan <span class="req">*</span></label>
                            <input type="text" name="jabatan" placeholder="Contoh: Ketua Panitia / Kepala Seksi / Mahasiswa" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Nomor Telepon / WhatsApp <span class="req">*</span></label>
                            <input type="tel" name="telepon" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Email Pemohon <span class="req">*</span></label>
                            <input type="email" name="email" placeholder="Contoh: pemohon@instansi.go.id" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Alamat Pemohon / Instansi <span class="req">*</span></label>
                            <textarea name="alamat" rows="2" placeholder="Masukkan alamat lengkap instansi atau perorangan" required></textarea>
                        </div>
                    </div>

                    {{-- 2. Detail Kegiatan --}}
                    <div class="peminjaman-form-section">
                        <div class="peminjaman-section-head">
                            <span class="peminjaman-section-num">2</span>
                            <h4>Detail Kegiatan</h4>
                        </div>

                        <div class="peminjaman-field">
                            <label>Nama Kegiatan <span class="req">*</span></label>
                            <input type="text" name="nama_kegiatan" placeholder="Contoh: Rapat Koordinasi Pengelolaan Air Tanah 2026" required>
                        </div>

                        <div class="peminjaman-field">
                            <label>Jenis Kegiatan <span class="req">*</span></label>
                            <select name="jenis_kegiatan" required>
                                <option value="" selected disabled>Pilih jenis kegiatan</option>
                                <option value="Rapat Teknis">Rapat Teknis / Koordinasi</option>
                                <option value="Seminar / Workshop">Seminar / Workshop</option>
                                <option value="Pelatihan / Bimtek">Pelatihan / Bimbingan Teknis</option>
                                <option value="Diskusi / Audiensi">Diskusi / Audiensi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="peminjaman-field">
                            <label>Tujuan Kegiatan <span class="req">*</span></label>
                            <textarea name="tujuan_kegiatan" rows="2" placeholder="Jelaskan tujuan dan konteks kegiatan yang akan dilaksanakan" required></textarea>
                        </div>

                        <div class="peminjaman-field">
                            <label>Tanggal Kegiatan <span class="req">*</span></label>
                            <input type="date" name="tanggal_kegiatan" required>
                        </div>

                        <div class="peminjaman-form-grid-two">
                        <div class="peminjaman-field">
                            <label>Jam Mulai <span class="req">*</span></label>
                            <input type="time" name="jam_mulai" required title="Jam Mulai">
                        </div>
                        <div class="peminjaman-field">
                            <label>Jam Selesai <span class="req">*</span></label>
                            <input type="time" name="jam_selesai" required title="Jam Selesai">
                        </div>
                    </div>
                    </div>

                    {{-- 3. Kebutuhan Ruangan --}}
                    <div class="peminjaman-form-section">
                        <div class="peminjaman-section-head">
                            <span class="peminjaman-section-num">3</span>
                            <h4>Kebutuhan Ruangan</h4>
                        </div>

                        <div class="peminjaman-field">
                            <label>Pilih Jenis Ruangan <span class="req">*</span></label>
                            <select name="jenis_ruangan" id="jenis_ruangan" required>
                                <option value="" selected disabled data-kapasitas="0">Pilih jenis ruangan yang dibutuhkan</option>
                                <option value="Ruang 1" data-kapasitas="4">Ruang 1 (Kapasitas Maksimal 4 Orang)</option>
                                <option value="Ruang 2" data-kapasitas="16">Ruang 2 (Kapasitas Maksimal 16 Orang)</option>
                                <option value="Ruang 3" data-kapasitas="8">Ruang 3 (Kapasitas Maksimal 8 Orang)</option>
                            </select>
                        </div>

                        <div class="peminjaman-field">
                            <label>Jumlah Peserta (Orang) <span class="req">*</span></label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" min="1" placeholder="Masukkan perkiraan jumlah peserta (contoh: 12)" required>
                        </div>

                        {{-- Dynamic Capacity Information Display Box --}}
                        <div id="capacity-info-box" class="capacity-info-box info" style="display: none;">
                            <i class="fa-solid fa-circle-info" id="capacity-icon"></i>
                            <span id="capacity-message">Silakan pilih jenis ruangan dan masukkan jumlah peserta.</span>
                        </div>
                    </div>

                    {{-- 4. Bagian Lampiran + Pernyataan --}}
                    <div>
                        <div class="peminjaman-form-section">
                            <div class="peminjaman-section-head">
                                <span class="peminjaman-section-num">4</span>
                                <h4>Bagian Lampiran Dokumen</h4>
                            </div>

                            <div class="peminjaman-field">
                                <label>Unggah Dokumen Pendukung (Surat yang Menerangkan mengenai Kegiatan yang akan Dilakukan) <span class="req">*</span></label>
                            </div>

                            <label class="peminjaman-dropzone">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <strong>Seret dan lepas file di sini</strong>
                                <span>atau klik untuk memilih file</span>
                                <span>Format: PDF, JPG, PNG, DOC, DOCX (Maks. 5MB)</span>
                                <input type="file" name="lampiran_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                <span class="file-name-tag"></span>
                            </label>
                        </div>

                        <div class="peminjaman-form-section">
                            <div class="peminjaman-section-head">
                                <span class="peminjaman-section-num">5</span>
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
                                    <span class="batdata-check-text">Saya menyetujui untuk mematuhi ketentuan dan tata tertib penggunaan ruangan serta menjaga fasilitas dengan baik.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="peminjaman-form-actions">
                    <div class="peminjaman-action-btns">
                        <button type="button" id="btn-reset-form" class="peminjaman-reset-btn">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset Form</span>
                        </button>
                        <button type="submit" class="peminjaman-submit-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan</span>
                        </button>
                    </div>
                    <span class="peminjaman-form-note">
                        <span class="req">*</span> Menandakan kolom wajib diisi.
                    </span>
                </div>
        </div>

        
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('peminjaman-isi-formulir-btn')?.addEventListener('click', function(e) {
        e.preventDefault();
        var formCard = document.getElementById('peminjaman-formulir');
        var isHidden = formCard.style.display === 'none';
        formCard.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    var roomSelect = document.getElementById('jenis_ruangan');
    var pesertaInput = document.getElementById('jumlah_peserta');
    var capacityBox = document.getElementById('capacity-info-box');
    var capacityIcon = document.getElementById('capacity-icon');
    var capacityMsg = document.getElementById('capacity-message');
    var btnReset = document.getElementById('btn-reset-form');

    // Dynamic Capacity Calculation & Warning Update
    function checkCapacity() {
        var selectedOpt = roomSelect.options[roomSelect.selectedIndex];
        var capacity = parseInt(selectedOpt.getAttribute('data-kapasitas') || '0', 10);
        var pesertaCount = parseInt(pesertaInput.value || '0', 10);

        if (!selectedOpt.value || capacity === 0) {
            capacityBox.style.display = 'none';
            return;
        }

        capacityBox.style.display = 'flex';

        if (pesertaCount > 0 && pesertaCount > capacity) {
            capacityBox.className = 'capacity-info-box warning';
            capacityIcon.className = 'fa-solid fa-triangle-exclamation';
            capacityMsg.innerHTML = '<strong>Peringatan Kapasitas:</strong> Jumlah peserta yang dimasukkan (<strong>' + pesertaCount + ' orang</strong>) melebihi kapasitas maksimal <strong>' + selectedOpt.value + '</strong> (' + capacity + ' orang). Silakan sesuaikan peserta atau pilih ruangan lain.';
        } else if (pesertaCount > 0) {
            capacityBox.className = 'capacity-info-box info';
            capacityIcon.className = 'fa-solid fa-circle-check';
            capacityMsg.innerHTML = '<strong>Kapasitas Sesuai:</strong> ' + selectedOpt.value + ' dapat menampung hingga <strong>' + capacity + ' orang</strong>. Jumlah peserta Anda: <strong>' + pesertaCount + ' orang</strong>.';
        } else {
            capacityBox.className = 'capacity-info-box info';
            capacityIcon.className = 'fa-solid fa-circle-info';
            capacityMsg.innerHTML = '<strong>Informasi Ruangan:</strong> ' + selectedOpt.value + ' memiliki kapasitas maksimal <strong>' + capacity + ' orang</strong>.';
        }
    }

    roomSelect?.addEventListener('change', checkCapacity);
    pesertaInput?.addEventListener('input', checkCapacity);

    // File Input Dropzone Labeling
    document.querySelectorAll('.peminjaman-dropzone input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            var dropzone = this.closest('.peminjaman-dropzone');
            var tag = dropzone.querySelector('.file-name-tag');
            if (this.files && this.files.length > 0) {
                dropzone.classList.add('has-file');
                if (tag) {
                    tag.innerHTML = '<i class="fa-solid fa-file-lines"></i> ' + this.files[0].name + ' <span class="remove-file-btn" title="Batal"><i class="fa-solid fa-xmark"></i></span>';
                    tag.style.display = 'inline-flex';

                    var removeBtn = tag.querySelector('.remove-file-btn');
                    if (removeBtn) {
                        removeBtn.onclick = function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            input.value = '';
                            input.dispatchEvent(new Event('change'));
                        };
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

    // Shared Reset Logic
    function clearForm() {
        var formCard = document.getElementById('peminjaman-formulir');
        formCard.querySelectorAll('input, textarea, select').forEach(function(el) {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else {
                el.value = '';
            }
        });
        capacityBox.style.display = 'none';

        document.querySelectorAll('.peminjaman-dropzone').forEach(function(dz) {
            dz.classList.remove('has-file');
            var tag = dz.querySelector('.file-name-tag');
            if (tag) {
                tag.innerHTML = '';
                tag.style.display = 'none';
            }
        });
    }

    // Reset Form Handler
    btnReset?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh isian formulir peminjaman ruangan?')) {
            clearForm();
        }
    });
});
</script>
@endpush
@endsection
