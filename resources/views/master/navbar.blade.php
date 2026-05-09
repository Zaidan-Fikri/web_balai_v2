<div class="site-topbar">
    <div class="container-fluid site-topbar-inner">
        <a
            class="sda-net-link"
            href="https://sda.pu.go.id/"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Buka website SDA-net"
        >
            <i class="fa-solid fa-house" aria-hidden="true"></i>
            <span>SDA-net</span>
        </a>
    </div>
</div>

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
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.tugas_dan_fungsi') }}">Tugas dan Fungsi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.visi_misi') }}">Visi & Misi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.struktur_organisasi') }}">Struktur Organisasi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.lokasi_dan_kontak') }}">Lokasi dan Kontak</a></li>
                                </ul>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" href="#">
                                    Publikasi
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.berita') }}">Berita</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.pengumuman') }}">Pengumuman</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.infografis') }}">Infografis</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.galeri') }}">Galeri</a></li>
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
                                    Pelayanan Publik
                                    <span class="menu-caret" aria-hidden="true">&gt;</span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.standar_pelayanan') }}">Standar Pelayanan</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.maklumat_pelayanan') }}">Maklumat Pelayanan</a></li>
                                    <li class="nav-item submenu flyout-parent">
                                        <a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">
                                            Permintaan Pelayanan
                                            <span class="menu-caret menu-caret-flyout" aria-hidden="true">&gt;</span>
                                        </a>
                                        <ul class="sub-menu flyout-card">
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_data') }}">Data</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_magang') }}">Magang</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_advis') }}">Advis</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.e_ppid') }}">E-PPID</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.layanan_pengaduan') }}">Layanan Pengaduan</a></li>
                                </ul>
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
