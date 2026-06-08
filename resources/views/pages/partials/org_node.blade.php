@php
    $nodeChildren = array_values(array_filter($allNodes, fn($n) => ($n['parent'] ?? null) == $node['id']));
    $nodeColor = $node['color'] ?? '#0047cc';
    $nodeName  = trim($node['name'] ?? '');
    $nodePos   = trim($node['position'] ?? '');
    $initSrc   = $nodeName ?: $nodePos;
    $initWords = preg_split('/[\s,\.]+/', $initSrc, 3, PREG_SPLIT_NO_EMPTY);
    $initials  = '';
    if (isset($initWords[0])) $initials .= mb_strtoupper(mb_substr($initWords[0], 0, 1));
    if (isset($initWords[1])) $initials .= mb_strtoupper(mb_substr($initWords[1], 0, 1));
    if (empty($initials)) $initials = '?';
@endphp
<li class="org-item">
    <div class="org-vline"></div>
    <div class="org-node-wrap" style="--nc: {{ $nodeColor }}">
        <div class="org-avatar">{{ $initials }}</div>
        <div class="org-card">
            @if ($nodeName)<strong class="org-name">{{ $nodeName }}</strong>@endif
            <span class="org-pos">{{ $nodePos }}</span>
        </div>
    </div>
    @if (!empty($nodeChildren))
        <div class="org-vline"></div>
        <ul class="org-children">
            @foreach ($nodeChildren as $nodeChild)
                @include('pages.partials.org_node', ['node' => $nodeChild, 'allNodes' => $allNodes])
            @endforeach
        </ul>
    @endif
</li>
