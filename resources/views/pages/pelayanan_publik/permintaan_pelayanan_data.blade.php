@extends('master.app')

@section('content')
<style>
    html, body {
        background-color: #f3f4f6;
    }

    .menu-detail-wrap {
        margin: 0 40px;
    }

    .detail-card {
        max-width: 1080px;
        margin: 30px auto 0;
        background: #fff;
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 14px 36px rgba(17, 39, 74, 0.08);
    }

    @media only screen and (max-width: 991px) {
        .menu-detail-wrap {
            margin: 0;
        }

        .detail-card {
            border-radius: 20px;
            padding: 20px;
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
                    Permintaan Pelayanan Data
                </h1>
                <p style="margin: 0; color: #fff; font-size: 20px;">
                    <a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Beranda</a>
                    <span style="margin: 0 10px;">/</span>
                    <span style="color: #ffd15b;">Pelayanan Publik</span>
                    <span style="margin: 0 10px; color: #fff;">/</span>
                    <span style="color: #ffd15b;">Permintaan Pelayanan Data</span>
                </p>
            </div>
        </div>

        <div class="detail-card">
            <h3 style="color: #11274a; margin-bottom: 14px;">Layanan Data</h3>
            <p style="margin: 0; color: #41556f;">
                Halaman ini digunakan untuk informasi dan pengajuan terkait permintaan data pada Balai Air Tanah.
            </p>
        </div>
    </div>
</section>
@endsection
