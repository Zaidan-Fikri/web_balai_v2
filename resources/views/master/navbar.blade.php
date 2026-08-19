<header class="site-header auto-hide-navbar" id="siteNavbar">
    <div class="site-navbar-wrap">
        <nav class="navbar navbar-expand-lg site-navbar" aria-label="Navigasi utama">
            <div class="container-fluid site-navbar-inner">
                <a class="navbar-brand site-brand" href="{{ route('home') }}" aria-label="Balai Air Tanah">
                    <img class="site-brand-logo" src="{{ asset('images/logo-pu.png') }}" alt="Logo PU">
                    <img
                        class="site-brand-text"
                        src="{{ asset('images/name-bat.png') }}"
                        alt="BALAI AIR TANAH - DIREKTORAT JENDERAL SUMBER DAYA AIR - KEMENTERIAN PEKERJAAN UMUM"
                    >
                </a>

                <div class="collapse navbar-collapse main-menu site-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav" id="menu">
                            <li class="nav-item">
                                <a class="nav-link nav-home" href="{{ route('home') }}" aria-label="Beranda">
                                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" href="#">
                                    Profil
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.index') }}">Tentang Kami</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.tugas_dan_fungsi') }}">Tugas dan Fungsi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.visi_misi') }}">Visi dan Misi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.struktur_organisasi') }}">Struktur Organisasi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.zona_integritas') }}">Zona Integritas</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.lokasi_dan_kontak') }}">Lokasi dan Kontak</a></li>
                                </ul>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" href="#">
                                    Pelayanan Publik
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item submenu flyout-parent">
                                        <a class="nav-link" href="#">
                                            Layanan Terpadu
                                            <span class="menu-caret menu-caret-flyout" aria-hidden="true">&gt;</span>
                                        </a>
                                        <ul class="sub-menu flyout-card">
                                            {{-- <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_advis') }}">Layanan Advis Teknis</a></li> --}}
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_data') }}">Layanan Data dan Informasi</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_magang') }}">Magang/Kunjungan</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.peminjaman_ruangan') }}">Peminjaman Ruangan</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" target="_blank" rel="noopener noreferrer" href="https://sahabat.pu.go.id/">E-PPID</a></li>
                                    <li class="nav-item"><a class="nav-link" target="_blank" rel="noopener noreferrer" href="https://www.lapor.go.id/">Layanan Pengaduan</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.standar_pelayanan') }}">Standar Pelayanan</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.maklumat_pelayanan') }}">Maklumat Pelayanan</a></li>
                                </ul>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" href="#">
                                    Informasi Publik
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_berkala') }}">Informasi Berkala</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_serta_merta') }}">Informasi Serta Merta</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_tersedia_setiap_saat') }}">Informasi Tersedia Setiap Saat</a></li>
                                </ul>
                            </li>
                            <li class="nav-item submenu submenu-end">
                                <a class="nav-link" href="#">
                                    Publikasi
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.berita') }}">Berita</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.buletin.index') }}">Edukasi Air Tanah</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.infografis') }}">Infografis</a></li>
                                    <li class="nav-item submenu flyout-parent">
                                        <a class="nav-link" href="#">
                                            Galeri
                                            <span class="menu-caret menu-caret-flyout" aria-hidden="true">&gt;</span>
                                        </a>
                                        <ul class="sub-menu flyout-card">
                                            <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.galeri.foto') }}">Foto</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.galeri.video') }}">Video</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.pengumuman') }}">Pengumuman</a></li>
                                </ul>
                            </li>
                            <li class="nav-item nav-search-item">
                                <button class="nav-search-toggle" type="button" id="navbarSearchToggle" aria-label="Buka pencarian" aria-expanded="false" aria-controls="navbarSearchForm">
                                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                </button>
                                <form class="nav-search-form" id="navbarSearchForm" action="{{ route('search') }}" method="GET" role="search">
                                    <label class="visually-hidden" for="navbarSearchInput">Cari</label>
                                    <input
                                        id="navbarSearchInput"
                                        type="search"
                                        name="q"
                                        value="{{ request('q') }}"
                                        placeholder="Cari..."
                                        autocomplete="off"
                                    >
                                    <button type="submit" aria-label="Cari">
                                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>
