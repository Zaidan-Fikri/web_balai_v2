@php
    $isLongTitle = mb_strlen($pageTitle ?? '') > 45;
@endphp
<section class="menu-detail-section">
    <div class="menu-detail-wrap">
        <div class="menu-detail-hero">
            <div>
                <h1 class="menu-detail-title{{ $isLongTitle ? ' menu-detail-title--long' : '' }}">{{ $pageTitle }}</h1>
            </div>
        </div>
    </div>
</section>
