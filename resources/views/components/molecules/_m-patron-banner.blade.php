@php
    $tag = $tag ?? 'aside';
@endphp

<div @class(array_filter([ 'm-patron-banner-container', (isset($variation) ? $variation : '') ]))>
    <{{ $tag }} @class([ 'm-patron-banner' ])>
        <div class='m-patron_logo'>
            <svg class="icon--bloomberg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--bloomberg"></use></svg>
        </div>
    </{{ $tag }}>
</div>
