@php
    $pageTitle = match (true) {
        request()->routeIs('admin.dashboard') => 'Dashboard',
        request()->routeIs('admin.berita.*') => 'Berita',
        request()->routeIs('admin.thumbnail.*') => 'Thumbnail',
        request()->routeIs('admin.pengumuman.*') => 'Pengumuman',
        request()->routeIs('admin.buletin.*') => 'Buletin',
        request()->routeIs('admin.jurnal') => 'Jurnal',
        request()->routeIs('admin.karya-ilmiah.*') => 'Karya Ilmiah',
        request()->routeIs('admin.sni.*') => 'SNI',
        request()->routeIs('admin.siatab.*') => 'SIATAB',
        request()->routeIs('admin.gems.*') => 'GEMS',
        request()->routeIs('admin.laporan-skm.*') => 'Laporan SKM',
        default => 'Admin Panel',
    };
    $adminEmail = session('admin_user_email', 'admin@bat.local');
@endphp

<div class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar" aria-expanded="true">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="topbar-copy">
        <p>CMS Balai Air Tanah</p>
        <h1>{{ $pageTitle }}</h1>
    </div>

    <div class="search" role="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari data pada halaman ini" aria-label="Cari data pada halaman ini">
    </div>

    <div class="topbar-actions">
        <a class="topbar-link" href="{{ route('home') }}">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Lihat Situs</span>
        </a>
        <div class="admin-pill" title="{{ $adminEmail }}">
            <i class="fa-solid fa-user-shield"></i>
            <span>{{ $adminEmail }}</span>
        </div>
    </div>
</div>
