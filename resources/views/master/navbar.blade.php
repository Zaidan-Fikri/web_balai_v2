<div class="site-topbar">
    <div class="container-fluid site-topbar-inner">
        <div class="site-topbar-left">
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

        <div class="site-topbar-right">
            <a class="topbar-contact" href="tel:+622220463967" aria-label="Hubungi Balai Air Tanah melalui nomor (022) 20463967">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                <span>(022) 20463967</span>
            </a>

            <nav class="topbar-social" aria-label="Media sosial Balai Air Tanah">
                <a href="https://x.com/pupr_sda" target="_blank" rel="noopener noreferrer" aria-label="X Balai Air Tanah">
                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                </a>
                <a href="https://www.instagram.com/pu_sda_balaiairtanah/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Balai Air Tanah">
                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="https://www.facebook.com/p/balaiairtanah-100063971832730/" target="_blank" rel="noopener noreferrer" aria-label="Facebook Balai Air Tanah">
                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                </a>
                <a href="https://www.youtube.com/@pu_sda" target="_blank" rel="noopener noreferrer" aria-label="YouTube Balai Air Tanah">
                    <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                </a>
            </nav>
        </div>
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
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.visi_misi') }}">Visi dan Misi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.struktur_organisasi') }}">Struktur Organisasi</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Informasi Pejabat</a></li>
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
                                        <a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">
                                            Layanan Terpadu
                                            <span class="menu-caret menu-caret-flyout" aria-hidden="true">&gt;</span>
                                        </a>
                                        <ul class="sub-menu flyout-card">
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_advis') }}">Layanan Advis</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_data') }}">Permintaan Data</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#">Peminjaman Ruangan</a></li>
                                            <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_magang') }}">Permintaan Magang</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" target="_blank" rel="noopener noreferrer" href="https://sahabat.pu.go.id/">E-PPID</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.layanan_pengaduan') }}">Layanan Pengaduan</a></li>
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
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.buletin.index') }}">Buletin</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.pengumuman') }}">Pengumuman</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.infografis') }}">Infografis</a></li>
                                    <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.galeri') }}">Galeri</a></li>
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
