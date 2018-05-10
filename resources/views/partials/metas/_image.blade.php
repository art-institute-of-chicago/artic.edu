@php
    $url = $seo->image;
    $twitterUrl = $seo->twitterImage ?? $seo->image;
    $w = $seo->width ?? 1200;
    $h = $seo->height ?? 630;
@endphp

@if ($url)
    <meta property="og:image"        content="{{ $url }}" />
    <meta property="og:image:width"  content="{{ $w }}" />
    <meta property="og:image:height" content="{{ $h }}" />
    <meta name="twitter:image"       content="{{ $twitterUrl }}" />
    <meta itemprop="image"           content="{{ $url }}" />
@endif
