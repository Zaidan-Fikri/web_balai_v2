<aside class="sidebar">
    <div class="sidebar-inner">
        <div class="brand">
            <i class="fa-solid fa-a"></i>
            <span>ADMIN</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Menu</div>
            <div class="menu-active-indicator" id="menuActiveIndicator"></div>
            <a class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.berita') ? 'active' : '' }}" href="{{ route('admin.berita') }}">
                <i class="fa-regular fa-lightbulb"></i><span>Berita</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.thumbnail') ? 'active' : '' }}" href="{{ route('admin.thumbnail') }}">
                <i class="fa-regular fa-file-lines"></i><span>Thumbnail</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.pengumuman') ? 'active' : '' }}" href="{{ route('admin.pengumuman') }}">
                <i class="fa-regular fa-bell"></i><span>Pengumuman</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.jurnal') ? 'active' : '' }}" href="{{ route('admin.jurnal') }}">
                <i class="fa-solid fa-diagram-project"></i><span>Jurnal</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.karya-ilmiah') ? 'active' : '' }}" href="{{ route('admin.karya-ilmiah') }}">
                <i class="fa-solid fa-book-open"></i><span>Karya Ilmiah</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.sni') ? 'active' : '' }}" href="{{ route('admin.sni') }}">
                <i class="fa-solid fa-ruler-combined"></i><span>SNI</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.siatab*') ? 'active' : '' }}" href="{{ route('admin.siatab') }}">
                <i class="fa-solid fa-images"></i><span>SIATAB</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.gems*') ? 'active' : '' }}" href="{{ route('admin.gems') }}">
                <i class="fa-solid fa-gem"></i><span>GEMS</span>
            </a>
            <a class="menu-item {{ request()->routeIs('admin.laporan-skm') ? 'active' : '' }}" href="{{ route('admin.laporan-skm') }}">
                <i class="fa-solid fa-chart-column"></i><span>Laporan SKM</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <a class="menu-item" href="{{ route('home') }}">
                <i class="fa-solid fa-house"></i><span>Home</span>
            </a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="menu-item logout" type="submit" style="width:100%;border:0;background:transparent;cursor:pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
