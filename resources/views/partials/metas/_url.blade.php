@php
    $app_url  = rtrim(config('app.url'), '/') . '/';
    $url      = $canonicalUrl ?? ($app_url . trim(Request::path(), '/'));
    $nofollow = $seo->nofollow ?? false;
@endphp

<link rel="canonical"    href="{!! $url !!}" />
<meta property="og:url"  content="{!! $url !!}" />
<meta name="twitter:url" content="{!! $url !!}" />

@if($nofollow)
    <meta name="robots" content="nofollow" />
@endif
