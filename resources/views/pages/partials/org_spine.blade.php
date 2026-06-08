@php
    $spineRows = [];
    foreach ($orgChartData as $n) {
        $row = (int)($n['row'] ?? 0);
        $spineRows[$row][] = $n;
    }
    ksort($spineRows);
    $spineRowKeys = array_keys($spineRows);
    $firstKey = $spineRowKeys[0] ?? 0;
    $lastKey  = end($spineRowKeys);

    $allLineStyles = array_unique(array_column($orgChartData, 'line_style'));
    $styleLabels = [
        'solid'    => 'Pejabat Struktural Sesuai Permen',
        'dashed'   => 'Pejabat Berdasarkan Keputusan Dirjen SDA',
        'dash-dot' => 'Pejabat Kesatkeran',
    ];

    $getNodeInitials = function (array $node): string {
        $src = trim(($node['name'] ?? '') ?: ($node['position'] ?? ''));
        $words = preg_split('/[\s,\.]+/', $src, 3, PREG_SPLIT_NO_EMPTY);
        $ini = '';
        if (isset($words[0])) $ini .= mb_strtoupper(mb_substr($words[0], 0, 1));
        if (isset($words[1])) $ini .= mb_strtoupper(mb_substr($words[1], 0, 1));
        return $ini ?: '?';
    };

    $renderNode = function (array $node) use ($getNodeInitials): string {
        $hasAvatar = !empty($node['name']);
        $cls = 'spine-node' . ($hasAvatar ? ' has-avatar' : '');
        $html = '<div class="' . $cls . '">';
        if ($hasAvatar) {
            $html .= '<div class="spine-node-content">';
            $html .= '<strong>' . e($node['name']) . '</strong>';
            $html .= '<span>' . e($node['position'] ?? '') . '</span>';
            $html .= '</div>';
            $html .= '<div class="spine-node-avatar">';
            if (!empty($node['photo'])) {
                $html .= '<img src="' . e($node['photo']) . '" class="spine-node-photo" alt=""'
                    . ' data-name="' . e($node['name'] ?? '') . '"'
                    . ' data-position="' . e($node['position'] ?? '') . '">';
            } else {
                $html .= '<div class="spine-node-initials">' . $getNodeInitials($node) . '</div>';
            }
            $html .= '</div>';
        } else {
            $html .= '<span>' . e($node['position'] ?? '') . '</span>';
        }
        $html .= '</div>';
        return $html;
    };
@endphp

<div class="spine-wrap">
    <div class="spine-outer">
        @foreach ($spineRows as $rowNum => $rowNodes)
            @php
                $cNode = collect($rowNodes)->first(fn($n) => ($n['side'] ?? 'center') === 'center');
                $lNode = collect($rowNodes)->first(fn($n) => ($n['side'] ?? '') === 'left');
                $rNode = collect($rowNodes)->first(fn($n) => ($n['side'] ?? '') === 'right');
                $isFirst = ($rowNum === $firstKey);
                $isLast  = ($rowNum === $lastKey);
            @endphp

            @if ($cNode)
                <div class="spine-row center-row {{ !empty($cNode['behind']) ? 'spine-row-behind' : '' }} {{ !empty($cNode['prominent']) ? 'spine-row-prominent' : '' }} {{ $isFirst ? 'is-first' : '' }} {{ $isLast ? 'is-last' : '' }}">
                    <div class="spine-spacer"></div>
                    <div class="spine-ctr-cell">{!! $renderNode($cNode) !!}</div>
                    <div class="spine-spacer"></div>
                </div>
            @else
                <div class="spine-row branch-row">
                    <div class="spine-half left {{ $lNode ? '' : 'spine-half-empty' }}">
                        @if ($lNode)
                            {!! $renderNode($lNode) !!}
                            <div class="spine-hline spine-hline-{{ $lNode['line_style'] ?? 'solid' }}"></div>
                        @endif
                    </div>
                    <div class="spine-half right {{ $rNode ? '' : 'spine-half-empty' }}">
                        @if ($rNode)
                            <div class="spine-hline spine-hline-{{ $rNode['line_style'] ?? 'solid' }}"></div>
                            {!! $renderNode($rNode) !!}
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    @php $usedLegendStyles = array_intersect($allLineStyles, array_keys($styleLabels)); @endphp
    @if (count($usedLegendStyles) > 1)
        <div class="spine-legend">
            <strong>Keterangan:</strong>
            @foreach ($styleLabels as $style => $label)
                @if (in_array($style, $allLineStyles))
                    <div class="spine-legend-item">
                        <div class="spine-legend-line spine-hline spine-hline-{{ $style }}"></div>
                        <span>: {{ $label }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
