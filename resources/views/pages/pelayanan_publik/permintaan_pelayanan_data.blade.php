@extends('master.app')

@section('title', 'Permintaan Pelayanan Data - Balai Air Tanah')

@section('content')
<section class="service-detail-section">
    <div class="service-detail-wrap">
        <div class="service-detail-hero">
            <div>
                <h1 class="service-detail-title">Permintaan Pelayanan Data</h1>
                <p class="service-detail-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="service-detail-separator">/</span>
                    <span class="service-detail-highlight">Pelayanan Publik</span>
                    <span class="service-detail-separator">/</span>
                    <span class="service-detail-highlight">Permintaan Pelayanan Data</span>
                </p>
            </div>
        </div>

        <div class="service-detail-card">
            <h3>Layanan Data</h3>
            <p>Halaman ini digunakan untuk informasi dan pengajuan terkait permintaan data pada Balai Air Tanah.</p>
        </div>
    </div>
</section>
@endsection
