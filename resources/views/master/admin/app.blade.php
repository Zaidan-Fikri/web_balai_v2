<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --surface: #f6f4f3;
            --white: #ffffff;
            --text: #161616;
            --text-soft: #767676;
            --line: #e4e1de;
            --sidebar: #f0efef;
            --good: #2f9b52;
            --warn: #d48a25;
            --bad: #d84f4f;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 86px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Manrope", sans-serif;
            color: var(--text);
            background: var(--surface);
            overflow: hidden;
        }

        body.mobile-sidebar-open {
            overflow: hidden;
        }

        .admin-shell {
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-columns: var(--sidebar-width) minmax(0, 1fr);
            overflow: hidden;
            transition: grid-template-columns .25s ease;
        }

        .admin-shell.collapsed {
            grid-template-columns: var(--sidebar-collapsed-width) minmax(0, 1fr);
        }

        .sidebar {
            background: var(--sidebar);
            border: 1px solid #dedbd8;
            padding: 24px 16px;
            position: sticky;
            top: 14px;
            height: calc(100vh - 28px);
            overflow-y: auto;
            overflow-x: hidden;
            transition: padding .25s ease;
            margin: 14px 0 14px 14px;
            border-radius: 22px;
            box-shadow: 0 14px 30px rgba(20, 25, 40, 0.12);
        }

        .sidebar-inner {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu {
            display: block;
            position: relative;
        }

        .menu-active-indicator {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            height: 0;
            border-radius: 12px;
            background: #111217;
            opacity: 0;
            transition: top .25s ease, height .25s ease, opacity .18s ease;
            pointer-events: none;
            z-index: 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }

        .admin-shell.collapsed .sidebar {
            padding-left: 10px;
            padding-right: 10px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
            font-weight: 800;
            padding: 4px 10px 18px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        .brand i {
            width: 26px;
            height: 26px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: rgba(142, 107, 255, 0.18);
            color: #5f43cf;
        }

        .menu-label {
            font-size: 12px;
            color: var(--text-soft);
            margin: 16px 8px 10px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #424242;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            white-space: nowrap;
            position: relative;
            z-index: 1;
            transition: background-color .2s ease, color .2s ease;
        }

        .menu-item i {
            width: 18px;
            text-align: center;
            color: #7c7c7c;
            flex-shrink: 0;
        }

        .menu-item.active {
            color: #fff;
        }

        .menu-item.active i {
            color: #fff;
        }

        .menu-item.logout {
            color: #c64040;
        }

        .menu-item.logout i {
            color: #c64040;
        }

        .menu-item span {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-shell.collapsed .brand {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .admin-shell.collapsed .brand span,
        .admin-shell.collapsed .menu-label,
        .admin-shell.collapsed .menu-item span {
            display: none;
        }

        .admin-shell.collapsed .menu-item {
            justify-content: center;
            padding-left: 10px;
            padding-right: 10px;
            gap: 0;
        }

        .admin-shell.collapsed .menu-active-indicator {
            border-radius: 10px;
        }

        .content {
            padding: 16px;
            display: grid;
            gap: 12px;
            height: 100vh;
            overflow-y: auto;
            min-width: 0;
        }

        .sidebar-backdrop {
            display: none;
        }

        .topbar {
            height: 52px;
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--line);
            display: flex;
            align-items: center;
            padding: 10px 14px;
            gap: 10px;
        }

        .sidebar-toggle {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: #fff;
            color: #4f4f4f;
            display: grid;
            place-items: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .search {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f4f4f4;
            border: 1px solid #ececec;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 13px;
            color: #7a7a7a;
        }

        .search input {
            border: 0;
            background: transparent;
            width: 100%;
            outline: none;
            font: inherit;
            color: #414141;
        }

        .top-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            border: 1px solid var(--line);
            color: #666;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffdd91, #ff9d64);
            color: #222;
            display: grid;
            place-items: center;
            font-size: 15px;
            font-weight: 700;
        }

        .panel {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 14px;
            max-width: 100%;
            overflow: hidden;
            min-width: 0;
        }

        .full-card {
            width: 100%;
            min-height: calc(100vh - 96px);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .content > section {
            margin: 0;
            width: 100%;
            min-width: 0;
        }

        .full-card > h3 {
            font-size: clamp(28px, 5vw, 40px) !important;
            line-height: 1.15 !important;
            word-break: break-word;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 14px;
            -webkit-overflow-scrolling: touch;
            width: 100%;
            display: block;
            max-width: 100%;
            min-width: 0;
        }

        .full-card .table-wrap {
            flex: 1;
            min-height: 0;
            min-width: 0;
            overflow: auto;
            border-radius: 12px;
            touch-action: pan-x pan-y;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
            font-size: 13px;
        }

        th, td {
            text-align: left;
            padding: 9px 8px;
            border-bottom: 1px solid #efefef;
            white-space: nowrap;
        }

        th {
            color: #666;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .full-card thead th {
            position: sticky;
            top: 0;
            background: var(--white);
            z-index: 2;
        }

        .status {
            font-weight: 700;
        }

        .status.good { color: var(--good); }
        .status.warn { color: var(--warn); }
        .status.bad { color: var(--bad); }

        @media (max-width: 1120px) {
            body {
                overflow: auto;
            }

            .admin-shell,
            .admin-shell.collapsed {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                top: 78px;
                left: 12px;
                right: 12px;
                z-index: 1100;
                height: auto;
                max-height: calc(100vh - 94px);
                overflow-y: auto;
                margin: 0;
                border-radius: 18px;
                border-right: 1px solid #dedbd8;
                border-bottom: 1px solid var(--line);
                transform: translateY(-10px) scale(.98);
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease, transform .2s ease;
            }

            .admin-shell.mobile-sidebar-open .sidebar {
                transform: translateY(0) scale(1);
                opacity: 1;
                pointer-events: auto;
            }

            .sidebar-backdrop {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(14, 18, 28, 0.35);
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s ease;
                z-index: 1090;
            }

            .admin-shell.mobile-sidebar-open .sidebar-backdrop {
                opacity: 1;
                pointer-events: auto;
            }

            .admin-shell.collapsed .brand span,
            .admin-shell.collapsed .menu-label,
            .admin-shell.collapsed .menu-item span {
                display: initial;
            }

            .admin-shell.collapsed .menu-item {
                justify-content: flex-start;
                gap: 10px;
                padding-left: 12px;
                padding-right: 12px;
            }

            .content {
                height: auto;
                overflow: visible;
            }
        }

        @media (max-width: 980px) {
            .full-card {
                min-height: calc(100dvh - 126px);
            }

            table {
                min-width: 560px;
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 14px;
                gap: 12px;
            }

            .topbar {
                height: auto;
                border-radius: 18px;
                padding: 12px;
                gap: 10px;
            }

            .sidebar-toggle {
                width: 46px;
                height: 46px;
                border-radius: 14px;
            }

            .search {
                min-height: 46px;
                padding: 10px 12px;
                border-radius: 999px;
                font-size: 13px;
            }

            .panel {
                border-radius: 20px;
                padding: 16px;
            }

            .full-card {
                min-height: calc(100dvh - 126px);
                height: auto;
            }
        }

        @media (max-width: 620px) {
            .content {
                padding: 12px;
                gap: 10px;
                min-height: 100dvh;
            }

            .panel {
                padding: 12px;
                border-radius: 18px;
            }

            table {
                width: max-content;
                min-width: 100%;
                font-size: 12px;
            }

            th, td {
                padding: 8px 6px;
            }

            .full-card {
                min-height: calc(100dvh - 118px);
                height: auto;
            }

            .full-card .table-wrap {
                margin-top: 10px;
                overflow: auto;
                padding-bottom: 2px;
            }
        }

        @media (max-width: 420px) {
            table {
                width: max-content;
                min-width: 100%;
                font-size: 11.5px;
            }
        }
    </style>
</head>
<body>
<div class="admin-shell" id="adminShell">
    @include('master.admin.sidebar')
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <main class="content">
        @include('master.admin.navbar')
        @yield('content')
    </main>
</div>

<script>
    (function () {
        const shell = document.getElementById('adminShell');
        const toggle = document.getElementById('sidebarToggle');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (!shell || !toggle) return;

        function isMobile() {
            return window.matchMedia('(max-width: 1120px)').matches;
        }

        function closeMobileSidebar() {
            shell.classList.remove('mobile-sidebar-open');
            document.body.classList.remove('mobile-sidebar-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', function () {
            if (isMobile()) {
                shell.classList.toggle('mobile-sidebar-open');
                document.body.classList.toggle('mobile-sidebar-open', shell.classList.contains('mobile-sidebar-open'));
                toggle.setAttribute('aria-expanded', shell.classList.contains('mobile-sidebar-open') ? 'true' : 'false');
                if (shell.classList.contains('mobile-sidebar-open')) {
                    const active = menu ? menu.querySelector('.menu-item.active') : null;
                    if (active) {
                        placeIndicator(active, false);
                    }
                }
                return;
            }

            shell.classList.toggle('collapsed');
            toggle.setAttribute('aria-expanded', shell.classList.contains('collapsed') ? 'false' : 'true');
        });

        if (backdrop) {
            backdrop.addEventListener('click', closeMobileSidebar);
        }

        const menu = document.querySelector('.sidebar-menu');
        const indicator = document.getElementById('menuActiveIndicator');
        const menuLinks = menu ? menu.querySelectorAll('.menu-item') : [];

        function placeIndicator(target, animate) {
            if (!menu || !indicator) return;
            if (!target) return;
            const menuRect = menu.getBoundingClientRect();
            const itemRect = target.getBoundingClientRect();
            indicator.style.transition = animate ? 'top .25s ease, height .25s ease, opacity .18s ease' : 'none';
            indicator.style.top = (itemRect.top - menuRect.top) + 'px';
            indicator.style.height = itemRect.height + 'px';
            indicator.style.opacity = '1';
            if (!animate) {
                requestAnimationFrame(function () {
                    indicator.style.transition = 'top .25s ease, height .25s ease, opacity .18s ease';
                });
            }
        }

        if (menu && indicator && menuLinks.length) {
            const initialActive = menu.querySelector('.menu-item.active');
            if (initialActive) {
                placeIndicator(initialActive, false);
            }
        }

        menuLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                if (isMobile()) {
                    event.preventDefault();
                    const currentActiveMobile = menu.querySelector('.menu-item.active');
                    if (currentActiveMobile) {
                        currentActiveMobile.classList.remove('active');
                    }
                    link.classList.add('active');
                    placeIndicator(link, true);
                    window.setTimeout(function () {
                        closeMobileSidebar();
                        window.location.href = link.href;
                    }, 180);
                    return;
                }
                event.preventDefault();

                const currentActive = menu.querySelector('.menu-item.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }
                link.classList.add('active');
                placeIndicator(link, true);

                window.setTimeout(function () {
                    window.location.href = link.href;
                }, 180);
            });
        });

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                closeMobileSidebar();
                const active = menu ? menu.querySelector('.menu-item.active') : null;
                if (active) {
                    placeIndicator(active, false);
                }
            } else if (shell.classList.contains('collapsed')) {
                shell.classList.remove('collapsed');
            }
        });
    })();
</script>
</body>
</html>
