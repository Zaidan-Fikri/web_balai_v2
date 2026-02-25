<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --card-bg: #f5f5f5;
            --text-main: #16171b;
            --text-soft: #747887;
            --input-border: #d6d8de;
            --accent: #f2483c;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Manrope", sans-serif;
            min-height: 100vh;
            background: linear-gradient(90deg, rgba(6, 9, 22, 0.95) 0 50%, #ececec 50% 100%);
            display: grid;
            place-items: center;
            color: var(--text-main);
            padding: 18px;
            overflow: hidden;
        }

        .page-wrap {
            width: min(1080px, 94vw);
            height: min(700px, calc(100vh - 36px));
            border-radius: 34px;
            background: var(--card-bg);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
        }

        .visual-panel {
            position: relative;
            min-height: 0;
            height: 100%;
            padding: 30px;
            color: var(--white);
            background:
                linear-gradient(135deg, rgba(1, 8, 28, 0.5), rgba(3, 3, 12, 0.85)),
                url("https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=1400&q=80") center/cover no-repeat;
        }

        .visual-top,
        .visual-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .visual-top a {
            color: var(--white);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-left: 16px;
        }

        .join-btn {
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 999px;
            padding: 10px 18px;
        }

        .visual-bottom {
            position: absolute;
            left: 30px;
            right: 30px;
            bottom: 24px;
        }

        .author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, #63c4ff, #3a8cff);
            font-size: 18px;
            font-weight: 700;
        }

        .author p {
            margin: 0;
            line-height: 1.25;
        }

        .author .name {
            font-size: 26px;
            font-weight: 700;
        }

        .author .role {
            font-size: 13px;
            opacity: 0.88;
        }

        .arrows {
            display: flex;
            gap: 10px;
        }

        .circle-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.45);
            display: grid;
            place-items: center;
        }

        .form-panel {
            padding: 28px 40px 22px;
            display: flex;
            flex-direction: column;
        }

        .form-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .lang-switch {
            border: 1px solid #e0e0e0;
            border-radius: 999px;
            padding: 10px 14px;
            font-size: 13px;
            color: #3d4152;
            background: #fff;
        }

        h1 {
            margin: 0;
            font-size: clamp(40px, 6vw, 64px);
            line-height: 1.05;
            font-weight: 800;
        }

        .subtitle {
            margin: 8px 0 18px;
            color: var(--text-soft);
            font-weight: 500;
        }

        .input {
            width: 100%;
            height: 48px;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background: #fff;
            padding: 0 16px;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .input.is-invalid {
            border-color: #f2483c;
        }

        .alert {
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .alert-error {
            background: #ffe8e6;
            color: #ac2f24;
            border: 1px solid #ffc7c2;
        }

        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin: 0 0 8px;
        }

        .forgot-row a {
            color: #9b7e72;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 8px 0 12px;
            color: #9aa0af;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            background: #d8dbe2;
            flex: 1;
        }

        .btn {
            width: 100%;
            height: 48px;
            border: 0;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-google {
            border: 1px solid var(--input-border);
            background: #fff;
            color: #2c3040;
            margin-bottom: 12px;
        }

        .btn-google i {
            margin-left: 8px;
        }

        .btn-login {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 14px 22px rgba(242, 72, 60, 0.34);
        }

        .signup {
            text-align: center;
            margin: 12px 0 14px;
            color: #777f92;
            font-size: 14px;
        }

        .signup a {
            text-decoration: none;
            color: #f25f54;
            font-weight: 700;
        }

        .socials {
            margin-top: auto;
            display: flex;
            justify-content: center;
            gap: 14px;
            color: #4f5668;
            font-size: 18px;
        }

        @media (max-width: 980px) {
            body {
                padding: 14px;
                background: #0d1021;
                overflow: auto;
            }

            .page-wrap {
                grid-template-columns: 1fr;
                height: auto;
                width: min(720px, 100%);
                border-radius: 28px;
            }

            .visual-panel {
                min-height: 360px;
                padding: 26px;
            }

            .visual-bottom {
                left: 26px;
                right: 26px;
                bottom: 24px;
            }

            .form-panel {
                padding: 28px 26px 24px;
            }

            h1 {
                font-size: 42px;
            }

            .brand {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .visual-top strong {
                font-size: 18px;
            }

            .visual-top a {
                font-size: 13px;
                margin-left: 10px;
            }

            .author .name {
                font-size: 22px;
            }

            .author .role {
                font-size: 12px;
            }

            .form-head {
                margin-bottom: 34px;
            }

            .brand {
                font-size: 24px;
            }

            h1 {
                font-size: 36px;
            }

            .subtitle {
                margin: 8px 0 24px;
            }
        }

        @media (max-width: 560px) {
            body {
                padding: 0;
                display: block;
                background: #0d1021;
            }

            .page-wrap {
                width: 100%;
                min-height: 100vh;
                border-radius: 0;
                box-shadow: none;
            }

            .visual-panel {
                min-height: 280px;
                padding: 20px 18px;
            }

            .join-btn {
                padding: 8px 14px;
            }

            .visual-bottom {
                left: 18px;
                right: 18px;
                bottom: 16px;
            }

            .avatar {
                width: 42px;
                height: 42px;
                font-size: 16px;
            }

            .author .name {
                font-size: 19px;
            }

            .arrows {
                gap: 6px;
            }

            .circle-btn {
                width: 34px;
                height: 34px;
            }

            .form-panel {
                padding: 22px 16px 18px;
            }

            .lang-switch {
                padding: 8px 12px;
                font-size: 12px;
            }

            h1 {
                font-size: 32px;
            }

            .input,
            .btn {
                height: 48px;
                font-size: 14px;
            }

            .socials {
                gap: 14px;
                font-size: 18px;
            }
        }

        @media (max-height: 760px) and (min-width: 981px) {
            .visual-panel {
                min-height: 620px;
            }

            .form-head {
                margin-bottom: 34px;
            }

            .subtitle {
                margin: 10px 0 20px;
            }
        }
    </style>
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
