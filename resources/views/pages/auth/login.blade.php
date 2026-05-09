<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Balai Air Tanah</title>
    <!-- Font memakai fallback lokal/sistem agar tidak bergantung Google Fonts saat local development. -->
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    @vite(['resources/css/auth.css'])
</head>
<body>
<div class="page-wrap">
    <section class="visual-panel">
    </section>

    <section class="form-panel">
        <div class="form-head">
            <div class="brand">BALAI AIR TANAH</div>
        </div>

        <h1>Hi, Admin</h1>
        <p class="subtitle">Welcome to BALAI AIR TANAH</p>

        <form action="{{ route('login.process') }}" method="post">
            @csrf
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            <input class="input {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input class="input {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-login">Login</button>
        </form>

    </section>
</div>
</body>
</html>
