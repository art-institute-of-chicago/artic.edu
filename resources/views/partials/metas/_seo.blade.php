@if (isset($seo))
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="og:type" content="article" />
    @include('partials.metas._title')
    @include('partials.metas._description')
    @include('partials.metas._url')
    @include('partials.metas._image')
    @include('partials.metas._citation')
@endif
