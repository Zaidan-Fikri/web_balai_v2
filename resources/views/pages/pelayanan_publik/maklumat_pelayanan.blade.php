@extends('master.app')

@section('title', 'Maklumat Pelayanan - Balai Air Tanah')

@push('styles')
<style>
    .maklumat-section {
        padding: 32px 0 64px;
        background: #fff;
    }

    /* ── Card: identik dengan standar-card ── */
    .maklumat-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(255, 234, 177, .17) 0%, rgba(179, 230, 255, .17) 100%);
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10,38,71,.05), 0 14px 34px rgba(10,38,71,.07);
        padding: 48px 52px;
        transition: box-shadow .22s ease, transform .22s ease;
    }

    /* Garis atas gradasi biru–kuning */
    .maklumat-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }

    /* Watermark "BAT" di kanan */
    .maklumat-card::after {
        content: "BAT";
        position: absolute;
        top: 30px;
        right: 15px;
        color: rgba(0, 51, 153, .032);
        font-size: clamp(4rem, 10vw, 8rem);
        font-weight: 900;
        letter-spacing: .02em;
        line-height: 1;
        pointer-events: none;
    }

    .maklumat-card > * {
        position: relative;
        z-index: 1;
    }

    /* ── Kicker / Sub-Judul (identik dengan standar-kicker) ── */
    .maklumat-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
        color: var(--bat-primary);
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .maklumat-kicker::before {
        content: "";
        width: 28px;
        height: 2px;
        border-radius: 999px;
        background: #f6c34a;
    }

    /* ── Judul Utama ── */
    .maklumat-title {
        font-family: var(--bat-font-title);
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 900;
        color: var(--bat-primary-dark, #061d3f);
        letter-spacing: -0.02em;
        margin: 0 0 24px;
    }

    /* ── Wrapper garis biru memanjang full (desc + quote box) ── */
    .maklumat-content-line {
        position: relative;
        border-left: 4px solid #D5E2FF;
        border-radius: 2px;
        padding-left: 18px;
    }

    /* ── Sub-Teks Keterangan ── */
    .maklumat-desc-wrapper {
        position: relative;
        margin-bottom: 28px;
    }

    .maklumat-desc-text {
        font-family: var(--bat-font-body);
        font-size: 14px;
        font-weight: 700;
        line-height: 1.75;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin: 0;
    }

    /* ── Kotak Pernyataan / Quote Box ── */
    .maklumat-quote-box {
        position: relative;
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 50%, #075985 100%);
        border-radius: 16px;
        padding: 44px 48px 36px;
        color: #ffffff;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(2, 132, 199, 0.22);
    }

    /* Lingkaran abstrak berkilau di latar belakang */
    .maklumat-quote-circles {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
    }

    .maklumat-circle {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0) 70%);
    }

    .maklumat-circle-1 {
        width: 320px;
        height: 320px;
        top: -80px;
        right: -60px;
        opacity: 0.8;
        animation: mklPulse 6s infinite alternate ease-in-out;
    }

    .maklumat-circle-2 {
        width: 240px;
        height: 240px;
        bottom: -80px;
        left: 40px;
        opacity: 0.5;
        animation: mklPulse 8s infinite alternate ease-in-out 1.2s;
    }

    .maklumat-circle-3 {
        width: 160px;
        height: 160px;
        top: 40%;
        left: 42%;
        opacity: 0.3;
        filter: blur(8px);
    }

    @keyframes mklPulse {
        0%   { transform: scale(1);    opacity: 0.5; }
        100% { transform: scale(1.15); opacity: 0.85; }
    }

    .maklumat-quote-content {
        position: relative;
        z-index: 1;
    }

    .maklumat-quote-icon {
        font-size: 30px;
        color: rgba(255, 255, 255, 0.38);
        margin-bottom: 14px;
    }

    /* Teks Pernyataan */
    .maklumat-statement-text {
        font-family: var(--bat-font-body);
        font-size: clamp(1rem, 1.7vw, 1.2rem);
        font-weight: 500;
        line-height: 1.85;
        color: #ffffff;
        text-align: left;
        margin-bottom: 28px;
    }

    /* Garis pemisah putih samar */
    .maklumat-divider {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, rgba(255,255,255,.35) 0%, rgba(255,255,255,.08) 100%);
        margin: 0 0 20px;
    }

    /* Nama Penandatangan */
    .maklumat-signee {
        text-align: right;
    }

    .maklumat-signee-name {
        font-family: var(--bat-font-title);
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: 0.02em;
        margin: 0;
    }

    .maklumat-signee-sub {
        font-family: var(--bat-font-body);
        font-size: 13px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.75);
        margin-top: 4px;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .maklumat-card {
            padding: 36px 30px;
        }
    }

    @media (max-width: 576px) {
        .maklumat-card {
            padding: 28px 20px;
        }

        .maklumat-quote-box {
            padding: 28px 22px 24px;
        }

        .maklumat-desc-text {
            font-size: 12.5px;
        }
    }
</style>
@endpush

@section('content')
{{-- Hero Banner (identik dengan standar_pelayanan) --}}
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Maklumat Pelayanan'])

<section class="maklumat-section">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span>Pelayanan Publik</span>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Maklumat Pelayanan</span>
        </nav>

        {{-- Kontainer Utama (Kartu) --}}
        <div class="maklumat-card wow fadeInUp" data-wow-delay="0.08s">

            {{-- Sub-Judul / Kategori --}}
            <p class="maklumat-kicker">PELAYANAN PUBLIK</p>

            {{-- Judul Utama --}}
            <h1 class="maklumat-title">Maklumat Pelayanan</h1>

            {{-- Wrapper garis biru full (membungkus desc + quote box) --}}
            <div class="maklumat-content-line">
                {{-- Sub-Teks Keterangan --}}
                <div class="maklumat-desc-wrapper">
                    <p class="maklumat-desc-text">
                        DITETAPKAN PADA TANGGAL 1 SEPTEMBER 2025 KEPUTUSAN KEPALA BALAI AIR TANAH
                        TENTANG MAKLUMAT PELAYANAN BALAI AIR TANAH
                    </p>
                </div>

                {{-- Kotak Pernyataan / Quote Box --}}
                <div class="maklumat-quote-box">

                    {{-- Pola lingkaran abstrak berkilau --}}
                    <div class="maklumat-quote-circles">
                        <div class="maklumat-circle maklumat-circle-1"></div>
                        <div class="maklumat-circle maklumat-circle-2"></div>
                        <div class="maklumat-circle maklumat-circle-3"></div>
                    </div>

                    <div class="maklumat-quote-content">
                        <div class="maklumat-quote-icon">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>

                        {{-- Pernyataan --}}
                        <p class="maklumat-statement-text">
                            "Dengan ini, kami menyatakan siap, sanggup, dan sigap dalam menyelenggarakan pelayanan
                            sesuai dengan Standar Pelayanan Publik yang ditetapkan, yaitu Bidang Layanan Teknis dan
                            Bidang Layanan Data, dan kami siap mematuhi sesuai peraturan perundang-undangan yang
                            berlaku"
                        </p>

                        {{-- Garis Pemisah --}}
                        <hr class="maklumat-divider">

                        {{-- Nama Penandatangan --}}
                        <div class="maklumat-signee">
                            <h4 class="maklumat-signee-name">Dr. Jossi Erwindy, S.T., M.T.</h4>
                            <p class="maklumat-signee-sub">Kepala Balai Air Tanah</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
