@php
    // Recommended lower limit to balance quality with speed
    $w = 1200; // $seo->width ?? 1200;
    $h = 800; //$seo->height ?? 800;

    // Assumes this is an Imgix URL
    $url = $seo->image . '?w=' . $w . '&h=' . $h . '&fit=crop';

    // TODO: Set the twitterImage separately?
    $twitterUrl = $seo->twitterImage ?? $url;
@endphp

@if ($url)
    <meta property="og:image"        content="{{ $url }}" />
    <meta property="og:image:width"  content="{{ $w }}" />
    <meta property="og:image:height" content="{{ $h }}" />
    <meta name="twitter:image"       content="{{ $twitterUrl }}" />
    <meta itemprop="image"           content="{{ $url }}" />
@endif
