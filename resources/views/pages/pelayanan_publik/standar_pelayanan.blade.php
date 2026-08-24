@extends('master.app')

@section('title', 'Standar Pelayanan - Balai Air Tanah')

@push('styles')
<style>
    .standar-section {
        padding: 32px 0 64px;
        background: #fff;
    }

    .standar-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, rgba(255, 234, 177, .17) 0%, rgba(179, 230, 255, .17) 100%);
        border-radius: 16px;
        border: 1px solid #e6ecf5;
        box-shadow: 0 2px 10px rgba(10,38,71,.05), 0 14px 34px rgba(10,38,71,.07);
        padding: 24px 28px;
        transition: box-shadow .22s ease, transform .22s ease;
    }

    .standar-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, #0047cc, #16a3e8, #f6c34a);
    }

    .standar-title {
        font-family: var(--bat-font-title);
        font-size: clamp(2rem, 3.5vw, 2.8rem);
        font-weight: 900;
        color: var(--bat-primary-dark, #061d3f);
        letter-spacing: -0.02em;
    }

    .standar-subtitle {
        font-family: var(--bat-font-body);
        font-size: 15px;
        line-height: 1.75;
        color: #64748b;
        max-width: 760px;
        margin: 12px auto 0;
    }

    /* Tabs Styling */
    .standar-tabs-wrapper {
        border-bottom: 2px solid #f1f5f9;
        margin: 40px 0 36px;
    }

    .standar-tabs {
        display: flex;
        justify-content: center;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .standar-tab-item {
        flex: 1;
        max-width: 360px;
    }

    .standar-tab-btn {
        width: 100%;
        background: none;
        border: none;
        padding: 16px 12px;
        font-family: var(--bat-font-title);
        font-size: 13.5px;
        font-weight: 800;
        letter-spacing: 0.06em;
        color: #94a3b8;
        text-align: center;
        text-transform: uppercase;
        cursor: pointer;
        position: relative;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
    }

    .standar-tab-btn:hover {
        color: var(--bat-primary, #0b2b5c);
        background-color: rgba(11, 43, 92, 0.02);
    }

    .standar-tab-btn.active {
        color: var(--bat-primary, #0b2b5c);
        border-bottom-color: var(--bat-primary, #0b2b5c);
        font-weight: 900;
    }

    /* Content Grid */
    .standar-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 32px;
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .standar-col-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 32px 28px;
        height: 100%;
        box-shadow: 0 4px 16px rgba(0, 31, 84, 0.015);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .standar-col-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(11, 43, 92, 0.06);
        border-color: #e2e8f0;
    }

    .standar-col-title {
        font-family: var(--bat-font-title);
        font-size: 19px;
        font-weight: 900;
        color: var(--bat-primary-dark, #061d3f);
        margin-bottom: 24px;
        padding-bottom: 14px;
        border-bottom: 1px dashed #e2e8f0;
    }

    /* Info Column Card Content */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 22px;
        flex: 1;
    }

    .info-item {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .info-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0056e2, #003699);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 86, 226, 0.25);
        transition: transform 0.25s ease;
    }

    .standar-col-card:hover .info-icon-circle {
        transform: scale(1.05);
    }

    .info-text-wrap {
        flex: 1;
        min-width: 0;
    }

    .info-label {
        font-family: var(--bat-font-title);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-val {
        font-family: var(--bat-font-body);
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        line-height: 1.5;
        word-break: break-word;
    }

    /* Products List Column Content */
    .product-list-wrapper {
        flex: 1;
    }

    .product-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .product-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        line-height: 1.5;
    }

    .product-item:last-child {
        margin-bottom: 0;
    }

    .product-item i {
        color: #22c55e;
        font-size: 15px;
        margin-top: 3px;
        flex-shrink: 0;
    }

    .product-sublist {
        list-style: none;
        padding-left: 26px;
        margin-top: 6px;
        margin-bottom: 4px;
    }

    .product-subitem {
        position: relative;
        padding-left: 14px;
        font-size: 12.5px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
    }

    .product-subitem::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #cbd5e1;
        font-size: 14px;
        top: -1px;
    }

    /* Schedule Column Content */
    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 22px;
        flex: 1;
    }

    /* Law Card Bottom Content */
    .law-card {
        background: linear-gradient(135deg, rgba(179, 230, 255, .45) 0%, rgba(255, 234, 177, .45) 100%);
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 28px 36px;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        transition: all 0.25s ease;
    }

    .law-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }

    .law-title {
        font-family: var(--bat-font-title);
        font-size: 15px;
        font-weight: 900;
        color: var(--bat-primary-dark, #061d3f);
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .law-title i {
        color: var(--bat-accent, #f4b000);
        font-size: 16px;
    }

    .law-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .law-item {
        position: relative;
        padding-left: 20px;
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.01em;
    }

    .law-item:last-child {
        margin-bottom: 0;
    }

    .law-item::before {
        content: "•";
        position: absolute;
        left: 6px;
        color: var(--bat-primary, #0b2b5c);
        font-size: 16px;
        top: -1px;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .standar-card {
            padding: 36px 30px;
        }

        .standar-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .standar-card {
            padding: 28px 20px;
        }

        .standar-tabs-wrapper {
            margin: 28px 0 24px;
        }

        .standar-tab-btn {
            font-size: 11px;
            padding: 12px 6px;
        }
    }
</style>
@endpush

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Standar Pelayanan'])

<section class="standar-section">
    <div class="container">
        {{-- Breadcrumbs --}}
        <nav class="page-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span>Pelayanan Publik</span>
            <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
            <span class="bc-current">Standar Pelayanan</span>
        </nav>

        {{-- Main Container Card --}}
        <div class="standar-card">
            {{-- Header --}}
            <div class="text-center">
                <h2 class="standar-title">Standar Pelayanan Publik</h2>
                <p class="standar-subtitle">
                    Standar Pelayanan Publik Balai Air Tanah merupakan pedoman dalam memberikan layanan yang profesional, transparan, mudah, cepat, terukur, dan akuntabel, guna menjamin kepastian serta meningkatkan kualitas pelayanan kepada masyarakat.
                </p>
            </div>

            {{-- Tabs --}}
            <div class="standar-tabs-wrapper">
                <ul class="standar-tabs">
                    <li class="standar-tab-item">
                        <button class="standar-tab-btn active" id="tab-btn-data" aria-selected="true">
                            Bidang Layanan Data
                        </button>
                    </li>
                    <li class="standar-tab-item">
                        <button class="standar-tab-btn" id="tab-btn-teknis" aria-selected="false">
                            Bidang Layanan Teknis
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Content: Bidang Layanan Data --}}
            <div class="standar-grid" id="content-layanan-data">
                {{-- Column 1: Informasi Pelayanan --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Informasi Pelayanan</h3>
                        <div class="info-list">
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Jangka Waktu Pelaksanaan</span><br>
                                    <span class="info-val">7 (tujuh) hari kerja</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-wallet"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Biaya/Tarif</span><br>
                                    <span class="info-val">Gratis/Rp 0</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-file-invoice"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Persyaratan Layanan</span><br>
                                    <span class="info-val">Pemohon mengajukan permintaan layanan kepada petugas Pelayanan Terpadu Satu Pintu (PTSP) Balai Air Tanah</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Produk Layanan Data --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Produk Layanan Data</h3>
                        <div class="product-list-wrapper">
                            <ul class="product-list">
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>
                                        Data Infrastruktur ATAB<br>(Air Tanah Air Baku)
                                        <ul class="product-sublist">
                                            <li class="product-subitem">Sumur Bor (JIAT & Air Baku)</li>
                                            <li class="product-subitem">Mata Air</li>
                                            <li class="product-subitem">PAH/ABSAH</li>
                                            <li class="product-subitem">Intake Sungai</li>
                                            <li class="product-subitem">Embung</li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Data Geolistrik 1D & 2D</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Column 3: Jadwal Pelayanan --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Jadwal Pelayanan</h3>
                        <div class="schedule-list">
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-calendar-days"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Senin - Kamis</span>
                                    <br>
                                    <span class="info-val">
                                        07.30 - 12.00 WIB<br>
                                        13.00 - 16.00 WIB
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-calendar-days"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Jumat</span>
                                    <br>
                                    <span class="info-val">
                                        07.30 - 12.00 WIB<br>
                                        12.30 - 16.30 WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content: Bidang Layanan Teknis --}}
            <div class="standar-grid" id="content-layanan-teknis" style="display: none;">
                {{-- Column 1: Informasi Pelayanan --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Informasi Pelayanan</h3>
                        <div class="info-list">
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Jangka Waktu Pelaksanaan</span><br>
                                    <span class="info-val">23 (dua puluh tiga) hari kerja</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-wallet"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Biaya/Tarif</span><br>
                                    <span class="info-val">Gratis/Rp 0</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-file-invoice"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Persyaratan Layanan</span><br>
                                    <span class="info-val">Pemohon mengajukan permintaan layanan kepada petugas Pelayanan Terpadu Satu Pintu (PTSP) Balai Air Tanah</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column 2: Produk Layanan Teknis --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Produk Layanan Teknis</h3>
                        <div class="product-list-wrapper">
                            <ul class="product-list">
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Geolistrik 1D</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Geolistrik 2D</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Logging Sumur Bor</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Pumping Test</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Borehole Camera</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Analisis Kualitas Air Tanah</div>
                                </li>
                                <li class="product-item">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div>Analisis Hasil Geolistrik 1D & 2D</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Column 3: Jadwal Pelayanan --}}
                <div>
                    <div class="standar-col-card">
                        <h3 class="standar-col-title">Jadwal Pelayanan</h3>
                        <div class="schedule-list">
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-calendar-days"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Senin - Kamis</span><br>
                                    <span class="info-val">
                                        07.30 - 12.00 WIB<br>
                                        13.00 - 16.00 WIB
                                    </span>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-icon-circle"><i class="fa-solid fa-calendar-days"></i></div>
                                <div class="info-text-wrap">
                                    <span class="info-label">Jumat</span><br>
                                    <span class="info-val">
                                        07.30 - 12.00 WIB<br>
                                        12.30 - 16.30 WIB
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dasar Hukum (Bottom) --}}
            <div class="mt-4">
                <div class="law-card">
                    <h4 class="law-title"><i class="fa-solid fa-scale-balanced"></i> Dasar Hukum</h4>
                    <ul class="law-list">
                        <li class="law-item">
                            Peraturan Menteri Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 15 Tahun 2014 Tentang Pedoman Standar Pelayanan
                        </li>
                        <li class="law-item">
                            Peraturan Menteri Pekerjaan Umum Nomor 1 Tahun 2025 Tentang Organisasi dan Tata Kerja Unit Pelaksana Teknis di Kementerian Pekerjaan Umum
                        </li>
                        <li class="law-item">
                            SNI ISO 37001:2016 Tentang Sistem Manajemen Anti Penyuapan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabBtnData = document.getElementById('tab-btn-data');
        const tabBtnTeknis = document.getElementById('tab-btn-teknis');
        const contentData = document.getElementById('content-layanan-data');
        const contentTeknis = document.getElementById('content-layanan-teknis');

        if (tabBtnData && tabBtnTeknis && contentData && contentTeknis) {
            tabBtnData.addEventListener('click', function () {
                tabBtnData.classList.add('active');
                tabBtnData.setAttribute('aria-selected', 'true');
                tabBtnTeknis.classList.remove('active');
                tabBtnTeknis.setAttribute('aria-selected', 'false');

                contentData.style.display = 'grid';
                contentTeknis.style.display = 'none';
            });

            tabBtnTeknis.addEventListener('click', function () {
                tabBtnTeknis.classList.add('active');
                tabBtnTeknis.setAttribute('aria-selected', 'true');
                tabBtnData.classList.remove('active');
                tabBtnData.setAttribute('aria-selected', 'false');

                contentTeknis.style.display = 'grid';
                contentData.style.display = 'none';
            });
        }
    });
</script>
@endpush
