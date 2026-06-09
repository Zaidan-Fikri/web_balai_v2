@php
    $adminRole = session('admin_user_role', 'kompu');
    $canSeeKompuMenu = in_array($adminRole, ['superadmin', 'kompu'], true);
    $canSeeLayananTeknisMenu = in_array($adminRole, ['superadmin', 'layanan_teknis'], true);
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
            @if ($canSeeKompuMenu)
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
                <a class="menu-item {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
                    <i class="fa-regular fa-lightbulb"></i><span>Berita</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.thumbnail.*') ? 'active' : '' }}" href="{{ route('admin.thumbnail.index') }}">
                    <i class="fa-regular fa-file-lines"></i><span>Thumbnail</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}" href="{{ route('admin.pengumuman.index') }}">
                    <i class="fa-regular fa-bell"></i><span>Pengumuman</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.buletin.*') ? 'active' : '' }}" href="{{ route('admin.buletin.index') }}">
                    <i class="fa-regular fa-newspaper"></i><span>Edukasi</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.infografis.*') ? 'active' : '' }}" href="{{ route('admin.infografis.index') }}">
                    <i class="fa-solid fa-chart-pie"></i><span>Infografis</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.jurnal') ? 'active' : '' }}" href="{{ route('admin.jurnal') }}">
                    <i class="fa-solid fa-diagram-project"></i><span>Jurnal</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.karya-ilmiah.*') ? 'active' : '' }}" href="{{ route('admin.karya-ilmiah.index') }}">
                    <i class="fa-solid fa-book-open"></i><span>Karya Ilmiah</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.sni.*') ? 'active' : '' }}" href="{{ route('admin.sni.index') }}">
                    <i class="fa-solid fa-ruler-combined"></i><span>SNI</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.siatab.*') ? 'active' : '' }}" href="{{ route('admin.siatab.index') }}">
                    <i class="fa-solid fa-images"></i><span>SIATAB</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.gems.*') ? 'active' : '' }}" href="{{ route('admin.gems.index') }}">
                    <i class="fa-solid fa-gem"></i><span>GEMS</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.laporan-skm.*') ? 'active' : '' }}" href="{{ route('admin.laporan-skm.index') }}">
                    <i class="fa-solid fa-chart-column"></i><span>Laporan SKM</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}">
                    <i class="fa-solid fa-images"></i><span>Galeri</span>
                </a>
                <a class="menu-item {{ request()->routeIs('admin.galeri-tile.*') ? 'active' : '' }}" href="{{ route('admin.galeri-tile.index') }}">
                    <i class="fa-solid fa-table-cells-large"></i><span>Tile Landing Page</span>
                </a>
            @endif
            @if ($canSeeLayananTeknisMenu)
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
