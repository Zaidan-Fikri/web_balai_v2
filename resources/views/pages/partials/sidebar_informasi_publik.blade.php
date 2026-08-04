@once
<style>
/* ── Layout Informasi Publik ─────────────────────────── */
.ip-layout {
    display: flex;
    gap: 28px;
    align-items: flex-start;
}
.ip-content { flex: 1; min-width: 0; order: 1; }

/* ── Sidebar ─────────────────────────────────────────── */
.ip-sidebar {
    flex-shrink: 0;
    width: 280px;
    order: 2;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(10,38,71,.10), 0 1px 4px rgba(10,38,71,.06);
    overflow: hidden;
    border: 1px solid #e8edf4;
}

/* Header */
.ip-sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 22px 18px;
    background: linear-gradient(135deg, #0f2d5a 0%, #1a6bcc 100%);
    position: relative;
    overflow: hidden;
}
.ip-sidebar-header::after {
    content: 'INFORMASI PUBLIK';
    position: absolute;
    right: -10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.9rem;
    font-weight: 900;
    color: rgba(255,255,255,.06);
    letter-spacing: .04em;
    pointer-events: none;
    white-space: nowrap;
}
.ip-sidebar-accent {
    display: block;
    width: 4px;
    height: 22px;
    background: linear-gradient(180deg, #f0b429, #f97316);
    border-radius: 3px;
    flex-shrink: 0;
}
.ip-sidebar-title {
    font-size: .78rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: .1em;
    text-transform: uppercase;
    line-height: 1;
}

/* Nav */
.ip-sidebar-nav { padding: 10px 0 6px; }

.ip-sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 22px;
    font-size: .9rem;
    font-weight: 500;
    color: #445577;
    text-decoration: none;
    transition: background .18s, color .18s, padding-left .18s;
    border-left: 3px solid transparent;
    position: relative;
}
.ip-sidebar-link + .ip-sidebar-link::before {
    content: '';
    position: absolute;
    top: 0; left: 22px; right: 22px;
    height: 1px;
    background: #f0f2f6;
}
.ip-sidebar-link-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: #f0f4fb;
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem;
    color: #6b84b0;
    flex-shrink: 0;
    transition: background .18s, color .18s;
}
.ip-sidebar-link-text {
    flex: 1;
    line-height: 1.3;
}
.ip-sidebar-arrow {
    font-size: .65rem;
    color: #c0cce0;
    flex-shrink: 0;
    transition: color .18s, transform .18s;
}

/* Hover */
.ip-sidebar-link:hover {
    background: #f4f7ff;
    color: var(--bat-primary);
    padding-left: 26px;
    border-left-color: #c5d8f5;
}
.ip-sidebar-link:hover .ip-sidebar-link-icon {
    background: #dde9fb;
    color: var(--bat-primary);
}
.ip-sidebar-link:hover .ip-sidebar-arrow {
    color: var(--bat-primary);
    transform: translateX(2px);
}

/* Active */
.ip-sidebar-link.active {
    background: linear-gradient(90deg, #e8f0fe, #f0f5ff);
    color: var(--bat-primary);
    font-weight: 700;
    border-left-color: var(--bat-primary);
    padding-left: 26px;
}
.ip-sidebar-link.active .ip-sidebar-link-icon {
    background: var(--bat-primary);
    color: #fff;
}
.ip-sidebar-link.active .ip-sidebar-arrow {
    color: var(--bat-primary);
    transform: translateX(2px);
}

@media (max-width: 900px) {
    .ip-layout { flex-direction: column; }
    .ip-sidebar { width: 100%; }
}
</style>
@endonce

<aside class="ip-sidebar">
    <div class="ip-sidebar-header">
        <span class="ip-sidebar-accent"></span>
        <span class="ip-sidebar-title">Informasi Publik</span>
    </div>
    <nav class="ip-sidebar-nav">
        <a href="{{ route('informasi_publik.informasi_berkala') }}"
           class="ip-sidebar-link {{ request()->routeIs('informasi_publik.informasi_berkala') ? 'active' : '' }}">
            <span class="ip-sidebar-link-icon"><i class="fa-solid fa-rotate"></i></span>
            <span class="ip-sidebar-link-text">Informasi Berkala</span>
            <i class="fa-solid fa-chevron-right ip-sidebar-arrow"></i>
        </a>
        <a href="{{ route('informasi_publik.informasi_serta_merta') }}"
           class="ip-sidebar-link {{ request()->routeIs('informasi_publik.informasi_serta_merta') ? 'active' : '' }}">
            <span class="ip-sidebar-link-icon"><i class="fa-solid fa-bolt"></i></span>
            <span class="ip-sidebar-link-text">Informasi Serta Merta</span>
            <i class="fa-solid fa-chevron-right ip-sidebar-arrow"></i>
        </a>
        <a href="{{ route('informasi_publik.informasi_tersedia_setiap_saat') }}"
           class="ip-sidebar-link {{ request()->routeIs('informasi_publik.informasi_tersedia_setiap_saat') ? 'active' : '' }}">
            <span class="ip-sidebar-link-icon"><i class="fa-solid fa-clock"></i></span>
            <span class="ip-sidebar-link-text">Informasi Tersedia Setiap Saat</span>
            <i class="fa-solid fa-chevron-right ip-sidebar-arrow"></i>
        </a>
    </nav>
</aside>
