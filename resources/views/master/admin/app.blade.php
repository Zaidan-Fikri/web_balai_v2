<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pu.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Manrope:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    @vite(['resources/css/admin.css'])
    @stack('styles')
</head>
<body
    data-open-create-popup="{{ $errors->any() && old('form_type') === 'create' ? 'true' : 'false' }}"
    data-open-import-preview="{{ session('geolistrik_import_preview') ? 'true' : 'false' }}"
>
<div class="admin-shell" id="adminShell">
    @include('master.admin.sidebar')
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <main class="content">
        @include('master.admin.navbar')
        @yield('content')
    </main>
</div>

@vite(['resources/js/admin.js', 'resources/js/admin-pages.js'])
@stack('scripts')
</body>
</html>
