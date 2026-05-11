<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Balai Air Tanah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Manrope:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    @vite(['resources/css/auth.css'])
</head>
<body>
<div class="page-wrap">
    <section class="visual-panel" aria-label="Informasi CMS Balai Air Tanah">
        <div class="visual-content">
            <div class="visual-badge">
                <i class="fa-solid fa-shield-halved"></i>
                Admin Area
            </div>
            <h2>Portal Kelola Informasi Balai Air Tanah</h2>
        </div>

        <div class="visual-bottom">
            <div class="logo-cluster">
                <img src="{{ asset('images/logo-pu.png') }}" alt="Logo PU">
                <span>
                    <strong>Balai Air Tanah</strong>
                    <small>Direktorat Sumber Daya Air</small>
                </span>
            </div>
            <a class="back-home" href="{{ route('home') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke situs
            </a>
        </div>
    </section>

    <section class="form-panel">
        <div class="form-head">
            <div class="brand">
                <img src="{{ asset('images/logo-pu.png') }}" alt="Logo PU">
                BALAI AIR TANAH
            </div>
        </div>

        <h1>Masuk CMS</h1>
        <p class="subtitle">Gunakan akun admin yang sudah terdaftar untuk mengakses panel pengelolaan konten.</p>

        <form class="login-form" action="{{ route('login.process') }}" method="post">
            @csrf
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <div class="field">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope"></i>
                    <input class="input {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" type="email" name="email" placeholder="admin@email.com" value="{{ old('email') }}" autocomplete="email" required>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input class="input {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                </div>
            </div>


            <button type="submit" class="btn btn-login">
                Login
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

    </section>
</div>
</body>
</html>
