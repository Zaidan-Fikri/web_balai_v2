@extends('master.app')

@section('title', $pageTitle . ' - Balai Air Tanah')

@section('content')
<section class="menu-detail-section">
    <div class="menu-detail-wrap">
        <div class="menu-detail-hero">
            <div>
                <h1 class="menu-detail-title">{{ $pageTitle }}</h1>
                <p class="menu-detail-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="menu-detail-separator">/</span>
                    <span class="menu-detail-highlight">{{ $menuGroup }}</span>
                    <span class="menu-detail-separator">/</span>
                    <span class="menu-detail-highlight">{{ $pageTitle }}</span>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
