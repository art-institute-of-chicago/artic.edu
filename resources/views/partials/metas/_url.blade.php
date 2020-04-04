@php
    $app_url  = 'https://' .rtrim(config('app.url'), '/') . '/';
    $url      = $canonicalUrl ?? ($app_url . trim(Request::path(), '/'));

    $robots = array_filter([
        (($seo->noindex ?? false) ? 'noindex' : null),
        (($seo->nofollow ?? false) ? 'nofollow' : null),
    ]);
@endphp

<link rel="canonical"    href="{!! $url !!}" />
<meta property="og:url"  content="{!! $url !!}" />
<meta name="twitter:url" content="{!! $url !!}" />

@if (config('aic.is_preview_mode'))
    <meta name="robots" content="noindex,nofollow" />
@else
    @if (!empty($robots))
        <meta name="robots" content="{{ implode(',', $robots) }}" />
    @endif
@endif
