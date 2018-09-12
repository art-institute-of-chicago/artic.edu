@php
    $description = strip_tags(join(' | ', array_filter([$globalDescriptionPrefix ?? null, $seo->description, $globalDescriptionSuffix ?? null])));
@endphp

<meta name="description"         content="{{ $description }}" />
<meta property="og:description"  content="{{ $description }}" />
<meta name="twitter:description" content="{{ $description }}" />
<meta itemprop="description"     content="{{ $description }}" />
