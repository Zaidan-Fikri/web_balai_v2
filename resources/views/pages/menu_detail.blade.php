@extends('master.app')

@section('content')
<style>
    html, body {
        background-color: #f3f4f6;
    }

    .menu-detail-wrap {
        margin: 0 40px;
    }

    @media only screen and (max-width: 991px) {
        .menu-detail-wrap {
            margin: 0;
        }
    }
</style>
<section style="padding: 0 0 70px; margin-top: -92px; background-color: #f3f4f6; position: relative; z-index: 0;">
    <div class="menu-detail-wrap">
        <div style="
            background-image: linear-gradient(rgba(17, 39, 74, 0.62), rgba(17, 39, 74, 0.62)), url('https://sda.pu.go.id/web/images/page-header.webp');
            background-size: cover;
            background-position: center;
            border-radius: 44px;
            min-height: 470px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 48px;
            overflow: hidden;
        ">
            <div>
                <h1 style="color: #fff; font-size: clamp(34px, 5.4vw, 78px); line-height: 1.1; margin-bottom: 18px;">
                    {{ $pageTitle }}
                </h1>
                <p style="margin: 0; color: #fff; font-size: 20px;">
                    <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Beranda</a>
                    <span style="margin: 0 10px;">/</span>
                    <span style="color: #ffd15b;">{{ $menuGroup }}</span>
                    <span style="margin: 0 10px; color: #fff;">/</span>
                    <span style="color: #ffd15b;">{{ $pageTitle }}</span>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
