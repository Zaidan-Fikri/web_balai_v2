<!-- Header Start -->
<!--<header class="main-header">-->
<div class="header-sticky sticky-top header-top">
    <nav class="navbar navbar-expand-lg bg-scroll">
        <div class="container-fluid">
            <!-- Logo Start -->
                        <a class="navbar-brand" href="{{ route('home') }}" style="display:flex;align-items:center;gap:10px;min-height:48px;margin-left:-12px;">
                <img src="{{ asset('images/logo-pu.png') }}" alt="Logo PU" style="width:38px;height:auto;display:block;">
                <span style="display:block;line-height:1.1;font-weight:700;text-transform:uppercase;">
                    <span style="display:block;color:white;font-size:18px;">Balai Air Tanah</span>
                    <span style="display:block;color:white;font-size:12px;">Kementerian Pekerjaan Umum</span>
                </span>
            </a>
            <!-- Logo End -->

            <!-- Main Menu Start -->
            <div class="collapse navbar-collapse main-menu">
                <div class="nav-menu-wrapper">
                    <ul class="navbar-nav mr-auto" id="menu">
                        <li class="nav-item menu-home"><a class="nav-link" href="{{ route('home') }}"><ion-icon name="home-outline" aria-hidden="true"></ion-icon></a></li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Profil <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('profil.tugas_dan_fungsi') }}">Tugas dan Fungsi</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('profil.visi_misi') }}">Visi & Misi</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('profil.struktur_organisasi') }}">Struktur Organisasi</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('profil.lokasi_dan_kontak') }}">Lokasi dan Kontak</a></li>
                            </ul>

                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Publikasi <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul>
                                <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.berita') }}">Berita</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.pengumuman') }}">Pengumuman</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.infografis') }}">Infografis</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('publikasi.galeri') }}">Galeri</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Informasi Publik <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul>
                                <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_berkala') }}">Informasi Berkala</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_serta_merta') }}">Informasi Serta Merta</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('informasi_publik.informasi_tersedia_setiap_saat') }}">Informasi Tersedia Setiap Saat</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Pelayanan Publik <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.standar_pelayanan') }}">Standar Pelayanan</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.maklumat_pelayanan') }}">Maklumat Pelayanan</a></li>
                                <li class="nav-item submenu flyout-parent">
                                    <a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan') }}">Permintaan Pelayanan <ion-icon name="chevron-forward-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                                    <ul class="sub-menu flyout-card">
                                        <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_data') }}">Data</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.permintaan_pelayanan_magang') }}">Magang</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.e_ppid') }}">E-PPID</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('pelayanan_publik.layanan_pengaduan') }}">Layanan Pengaduan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#"><ion-icon name="search-outline" aria-hidden="true"></ion-icon><ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <form role="search" action="https://sda.pu.go.id/pencarian" method="post">
                                        <div class="simple-search input-group">
                                            <input type="hidden" name="csrf_test_name" value="e5801c3e000816127e1d702742d63a94" />                                            <input class="form-control text-1 bg-warning" id="headerSearch" name="keywords" type="search" value="" placeholder="Search...">
                                            <button class="btn" type="submit">
                                                <ion-icon name="search-outline" class="header-nav-top-icon" aria-hidden="true"></ion-icon>
                                            </button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item submenu">
                            <a class="nav-link" href="#">
                                <img src="https://flagcdn.com/w20/id.png" width="20" style="max-width: 20px"  alt="Indonesia"> <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/lang/id"><img src="https://flagcdn.com/w20/id.png" alt="Indonesia" width="20" style="max-width: 20px"> Indonesia</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/lang/en"><img src="https://flagcdn.com/w20/us.png" alt="English" width="20" style="max-width: 20px"> English</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Main Menu End -->
            <div class="navbar-toggle"></div>
        </div>
    </nav>
    <div class="responsive-menu"></div>
</div>
<!--</header>-->
<!-- Header End -->
