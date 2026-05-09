@extends('master.app')

@section('title', 'Permintaan Pelayanan Magang - Balai Air Tanah')

@section('content')
<section class="service-detail-section">
    <div class="service-detail-wrap">
        <div class="service-detail-hero">
            <div>
                <h1 class="service-detail-title">Permintaan Pelayanan Magang</h1>
                <p class="service-detail-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="service-detail-separator">/</span>
                    <span class="service-detail-highlight">Pelayanan Publik</span>
                    <span class="service-detail-separator">/</span>
                    <span class="service-detail-highlight">Permintaan Pelayanan Magang</span>
                </p>
            </div>
        </div>

        <div class="service-detail-card">
            <h3>Layanan Magang</h3>
            <p>Halaman ini digunakan untuk informasi dan pengajuan program magang di lingkungan Balai Air Tanah.</p>
        </div>
    </div>
</section>
@endsection
