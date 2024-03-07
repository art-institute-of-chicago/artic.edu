@php
    $tag = $tag ?? 'aside';
@endphp

<div @class([ 'm-patron-banner-container' ])>
    <{{ $tag }} @class([ 'm-patron-banner' ])>
        <div class='m-patron_logo'>
            <svg class="icon--bloomberg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--bloomberg"></use></svg>
        </div>
    </{{ $tag }}>
</div>
