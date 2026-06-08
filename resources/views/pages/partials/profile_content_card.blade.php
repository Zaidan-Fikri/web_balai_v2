@php
    $profileContentTitle = $title ?? 'Profil';
    $profileContentValue = $content ?? null;
    $profileContentKicker = $kicker ?? 'Profil Balai Air Tanah';
    $profileContentPreview = $preview ?? false;
    $profileContentShowTips = $showTips ?? false;
    $profileContentTitleId = $titleId ?? null;
    $profileContentBodyId = $bodyId ?? null;
    $profileContentTipsTitleId = $tipsTitleId ?? null;
    $profileContentEmptyText = $emptyText ?? 'Konten yang ditulis akan tampil di halaman publik.';

    $renderProfileContentCard = function (?string $content, string $headingTag = 'h3'): string {
        $lines = preg_split('/\R/', trim((string) $content));
        $html = '';
        $paragraph = [];
        $list = [];
        $orderedList = [];

        $flushParagraph = function () use (&$html, &$paragraph): void {
            if ($paragraph === []) return;
            $html .= '<p>' . e(implode(' ', $paragraph)) . '</p>';
            $paragraph = [];
        };
        $flushList = function () use (&$html, &$list): void {
            if ($list === []) return;
            $html .= '<ul>';
            foreach ($list as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ul>';
            $list = [];
        };
        $flushOrderedList = function () use (&$html, &$orderedList): void {
            if ($orderedList === []) return;
            $html .= '<ol>';
            foreach ($orderedList as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ol>';
            $orderedList = [];
        };
        $flushAll = function () use ($flushParagraph, $flushList, $flushOrderedList): void {
            $flushParagraph();
            $flushList();
            $flushOrderedList();
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                $flushAll();
                continue;
            }
            if (str_starts_with($line, '## ')) {
                $flushAll();
                $html .= '<' . $headingTag . '>' . e(trim(substr($line, 3))) . '</' . $headingTag . '>';
                continue;
            }
            $normalizedHeading = strtolower(rtrim($line, ':'));
            if (preg_match('/^[A-Za-zÀ-ÿ ]+:$/', $line) || in_array($normalizedHeading, ['visi', 'misi', 'tugas', 'fungsi'], true)) {
                $flushAll();
                $html .= '<' . $headingTag . '>' . e(rtrim($line, ':')) . '</' . $headingTag . '>';
                continue;
            }
            if (str_starts_with($line, '- ')) {
                $flushParagraph();
                $flushOrderedList();
                $list[] = trim(substr($line, 2));
                continue;
            }
            if (preg_match('/^(?:\d+|[a-zA-Z])[\.\)]\s+(.+)$/', $line, $matches)) {
                $flushParagraph();
                $flushList();
                $orderedList[] = trim($matches[1]);
                continue;
            }
            $flushList();
            $flushOrderedList();
            $paragraph[] = $line;
        }

        $flushAll();

        return $html;
    };
@endphp

<div class="profile-content-card {{ $profileContentPreview ? 'is-preview' : '' }}">
    <div class="profile-content-heading">
        <p class="profile-content-kicker">{{ $profileContentKicker }}</p>
        <h2 class="profile-content-title" @if ($profileContentTitleId) id="{{ $profileContentTitleId }}" @endif>{{ $profileContentTitle }}</h2>
    </div>

    <div class="profile-content-body {{ $profileContentValue ? 'has-content' : '' }}" @if ($profileContentBodyId) id="{{ $profileContentBodyId }}" @endif>
        @if ($profileContentValue)
            {!! $renderProfileContentCard($profileContentValue, $profileContentPreview ? 'h5' : 'h3') !!}
        @else
            <div class="profile-content-empty">{{ $profileContentEmptyText }}</div>
        @endif
    </div>

    @if ($profileContentShowTips)
        <div class="profile-content-tips">
            <strong @if ($profileContentTipsTitleId) id="{{ $profileContentTipsTitleId }}" @endif>Saran isi {{ $profileContentTitle }}</strong>
            <span>Mulai dengan ringkasan utama, lanjutkan detail penting, lalu susun poin-poin agar mudah dipindai pembaca.</span>
            <span>Gunakan paragraf pendek agar nyaman dibaca di halaman publik.</span>
        </div>
    @endif
</div>
