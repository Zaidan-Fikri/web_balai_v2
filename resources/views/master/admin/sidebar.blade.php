@php
    $adminRole = session('admin_user_role', '');
    $adminPerms = session('admin_user_permissions', []);
    $isSuperadmin = $adminRole === 'superadmin';
    $can = fn(string $key): bool => $isSuperadmin || in_array($key, $adminPerms, true);

    $activeProfileSlug = optional(request()->route('profilePage'))->slug;
    $profileMenuItems = [
        ['slug' => 'tentang-kami', 'label' => 'Tentang Kami', 'icon' => 'fa-solid fa-circle-info'],
        ['slug' => 'tugas-dan-fungsi', 'label' => 'Tugas dan Fungsi', 'icon' => 'fa-solid fa-list-check'],
        ['slug' => 'visi-dan-misi', 'label' => 'Visi dan Misi', 'icon' => 'fa-solid fa-bullseye'],
        ['slug' => 'struktur-organisasi', 'label' => 'Struktur Organisasi', 'icon' => 'fa-solid fa-sitemap'],
        ['slug' => 'zona-integritas', 'label' => 'Zona Integritas', 'icon' => 'fa-solid fa-shield-halved'],
        ['slug' => 'lokasi-dan-kontak', 'label' => 'Lokasi dan Kontak', 'icon' => 'fa-solid fa-location-dot'],
    ];
    $profileMenuOpen = request()->routeIs('admin.profile-pages.*');
    $publikasiMenuOpen = request()->routeIs(
        'admin.berita.*', 'admin.buletin.*', 'admin.infografis.*', 'admin.galeri.*', 'admin.pengumuman.*'
    );
    $homePageMenuOpen = request()->routeIs('admin.thumbnail.*', 'admin.galeri-tile.*');
@endphp

<aside class="sidebar">
    <div class="sidebar-inner">
        <div class="brand">
            <img class="brand-logo" src="{{ asset('images/logo-pu.png') }}" alt="Logo PU">
            <span>
                <span class="brand-title">CMS BAT</span>
                <span class="brand-subtitle">Balai Air Tanah</span>
            </span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <div class="menu-active-indicator" id="menuActiveIndicator"></div>
            <a class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
            </a>
            @if ($isSuperadmin)
                <a class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fa-solid fa-users-gear"></i><span>Manajemen Akun</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                    <i class="fa-solid fa-shield-halved"></i><span>Manajemen Role</span>
                </a>
            @endif
            @if ($can('profil'))
                <details class="menu-group {{ $profileMenuOpen ? 'is-open' : '' }}" {{ $profileMenuOpen ? 'open' : '' }}>
                    <summary class="menu-item menu-group-toggle {{ $profileMenuOpen ? 'has-active-child' : '' }}">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Profil</span>
                        <i class="fa-solid fa-chevron-down menu-group-caret"></i>
                    </summary>
                    <div class="menu-sublist">
                        @foreach ($profileMenuItems as $profileMenuItem)
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.profile-pages.*') && $activeProfileSlug === $profileMenuItem['slug'] ? 'active' : '' }}" href="{{ route('admin.profile-pages.edit', $profileMenuItem['slug']) }}">
                                <i class="{{ $profileMenuItem['icon'] }}"></i><span>{{ $profileMenuItem['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </details>
            @endif

            @php
                $showPubGroup = $can('publikasi_berita') || $can('publikasi_pengumuman') || $can('publikasi_edukasi') || $can('publikasi_infografis') || $can('publikasi_galeri');
                $showHomeGroup = $can('home_thumbnail') || $can('home_tile');
            @endphp

            @if ($showPubGroup)
                <details class="menu-group {{ $publikasiMenuOpen ? 'is-open' : '' }}" {{ $publikasiMenuOpen ? 'open' : '' }}>
                    <summary class="menu-item menu-group-toggle {{ $publikasiMenuOpen ? 'has-active-child' : '' }}">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>Publikasi</span>
                        <i class="fa-solid fa-chevron-down menu-group-caret"></i>
                    </summary>
                    <div class="menu-sublist">
                        @if ($can('publikasi_berita'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
                                <i class="fa-regular fa-lightbulb"></i><span>Berita</span>
                            </a>
                        @endif
                        @if ($can('publikasi_pengumuman'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}" href="{{ route('admin.pengumuman.index') }}">
                                <i class="fa-regular fa-bell"></i><span>Pengumuman</span>
                            </a>
                        @endif
                        @if ($can('publikasi_edukasi'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.buletin.*') ? 'active' : '' }}" href="{{ route('admin.buletin.index') }}">
                                <i class="fa-regular fa-newspaper"></i><span>Edukasi</span>
                            </a>
                        @endif
                        @if ($can('publikasi_infografis'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.infografis.*') ? 'active' : '' }}" href="{{ route('admin.infografis.index') }}">
                                <i class="fa-solid fa-chart-pie"></i><span>Infografis</span>
                            </a>
                        @endif
                        @if ($can('publikasi_galeri'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}">
                                <i class="fa-solid fa-images"></i><span>Galeri</span>
                            </a>
                        @endif
                    </div>
                </details>
            @endif

            @if ($showHomeGroup)
                <details class="menu-group {{ $homePageMenuOpen ? 'is-open' : '' }}" {{ $homePageMenuOpen ? 'open' : '' }}>
                    <summary class="menu-item menu-group-toggle {{ $homePageMenuOpen ? 'has-active-child' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Home Page</span>
                        <i class="fa-solid fa-chevron-down menu-group-caret"></i>
                    </summary>
                    <div class="menu-sublist">
                        @if ($can('home_thumbnail'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.thumbnail.*') ? 'active' : '' }}" href="{{ route('admin.thumbnail.index') }}">
                                <i class="fa-regular fa-file-lines"></i><span>Thumbnail</span>
                            </a>
                        @endif
                        @if ($can('home_tile'))
                            <a class="menu-item menu-subitem {{ request()->routeIs('admin.galeri-tile.*') ? 'active' : '' }}" href="{{ route('admin.galeri-tile.index') }}">
                                <i class="fa-solid fa-table-cells-large"></i><span>Tile Landing Page</span>
                            </a>
                        @endif
                    </div>
                </details>
            @endif

            @if ($can('informasi_publik'))
                <details class="menu-group {{ request()->routeIs('admin.informasi-berkala.*', 'admin.informasi-serta-merta.*', 'admin.informasi-tersedia-setiap-saat.*') ? 'is-open' : '' }}" {{ request()->routeIs('admin.informasi-berkala.*', 'admin.informasi-serta-merta.*', 'admin.informasi-tersedia-setiap-saat.*') ? 'open' : '' }}>
                    <summary class="menu-item menu-group-toggle {{ request()->routeIs('admin.informasi-berkala.*', 'admin.informasi-serta-merta.*', 'admin.informasi-tersedia-setiap-saat.*') ? 'has-active-child' : '' }}">
                        <i class="fa-solid fa-folder-open"></i>
                        <span>Informasi Publik</span>
                        <i class="fa-solid fa-chevron-down menu-group-caret"></i>
                    </summary>
                    <div class="menu-sublist">
                        <a class="menu-item menu-subitem {{ request()->routeIs('admin.informasi-berkala.*') ? 'active' : '' }}" href="{{ route('admin.informasi-berkala.index') }}">
                            <i class="fa-solid fa-file-lines"></i><span>Informasi Berkala</span>
                        </a>
                        <a class="menu-item menu-subitem {{ request()->routeIs('admin.informasi-serta-merta.*') ? 'active' : '' }}" href="{{ route('admin.informasi-serta-merta.index') }}">
                            <i class="fa-solid fa-file-lines"></i><span>Informasi Serta Merta</span>
                        </a>
                        <a class="menu-item menu-subitem {{ request()->routeIs('admin.informasi-tersedia-setiap-saat.*') ? 'active' : '' }}" href="{{ route('admin.informasi-tersedia-setiap-saat.index') }}">
                            <i class="fa-solid fa-file-lines"></i><span>Tersedia Setiap Saat</span>
                        </a>
                    </div>
                </details>
            @endif
            @if ($can('jurnal'))
                <a class="menu-item {{ request()->routeIs('admin.jurnal') ? 'active' : '' }}" href="{{ route('admin.jurnal') }}">
                    <i class="fa-solid fa-diagram-project"></i><span>Jurnal</span>
                </a>
            @endif
            @if ($can('karya_ilmiah'))
                <a class="menu-item {{ request()->routeIs('admin.karya-ilmiah.*') ? 'active' : '' }}" href="{{ route('admin.karya-ilmiah.index') }}">
                    <i class="fa-solid fa-book-open"></i><span>Karya Ilmiah</span>
                </a>
            @endif
            @if ($can('sni'))
                <a class="menu-item {{ request()->routeIs('admin.sni.*') ? 'active' : '' }}" href="{{ route('admin.sni.index') }}">
                    <i class="fa-solid fa-ruler-combined"></i><span>SNI</span>
                </a>
            @endif
            @if ($can('laporan_skm'))
                <a class="menu-item {{ request()->routeIs('admin.laporan-skm.*') ? 'active' : '' }}" href="{{ route('admin.laporan-skm.index') }}">
                    <i class="fa-solid fa-chart-column"></i><span>Laporan SKM</span>
                </a>
            @endif
            @if ($can('geolistrik_1d'))
                <a class="menu-item {{ request()->routeIs('admin.geolistrik-1d.*') ? 'active' : '' }}" href="{{ route('admin.geolistrik-1d.index') }}">
                    <i class="fa-solid fa-wave-square"></i><span>Geolistrik 1D</span>
                </a>
            @endif
        </div>

        <div class="sidebar-footer">
            <a class="menu-item" href="{{ route('home') }}">
                <i class="fa-solid fa-house"></i><span>Home</span>
            </a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="menu-item logout" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
