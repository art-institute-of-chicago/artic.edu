@php
    $title = join(' | ', array_filter([$globalPrefix ?? null, $seo->title, $globalSuffix ?? null]));
@endphp

<title>{{ $title }}</title>
@if (isset($globalSuffix))
<meta property="og:site_name"  content="{{ $globalSuffix }}" />
@endif
<meta property="og:title"      content="{{ $title }}" />
<meta name="twitter:title"     content="{{ $title }}" />
<meta itemprop="name"          content="{{ $title }}" />
