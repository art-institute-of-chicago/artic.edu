@if(isset($compareHtml))
  @include('cms-toolkit::layouts.compare')
@elseif (isset($preview) && $preview)
  @include('cms-toolkit::layouts.preview')
@else
<!DOCTYPE html>

<html dir="ltr" lang="en-US" class="not-ie no-js @yield('html_class')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    @section('meta_title') @include('partials.metas._title') @show
    @section('meta_description') @include('partials.metas._description') @show
    @section('meta_url') @include('partials.metas._url') @show
    @section('meta_image') @include('partials.metas._image') @show

    <meta name="copyright" content="(c) {{ date('Y') }} The Art Institute of Chicago" />
    <link type="text/plain" rel="author" href="humans.txt" />

    <!-- iOS -->
    <meta name="apple-mobile-web-app-title" content="The Art Institute of Chicago" />
    <meta name="format-detection" content="telephone=no" />

    <!-- Android -->
    <meta name="theme-color" content="#000000" />

    <!-- Facebook / Open Graph globals -->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="The Art Institute of Chicago" />
    {{-- <meta property="og:author" content="https://www.facebook.com/pentagramdesign/" /> --}}
    {{-- <meta property="fb:admins" content="" /> --}}

    <!-- Twitter globals -->
    {{-- <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@pentagram" />
    <meta name="twitter:domain" content="pentagram.com" />
    <meta name="twitter:creator" content="@pentagram" /> --}}

     <!-- Main Favicon -->
    <link rel="shortcut icon" href="/dist/images/favicon.ico">
    <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
    <link rel="apple-touch-icon" href="/dist/images/favicon-152.png"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
    <link rel="apple-touch-icon" type="image/png" href="/dist/images/favicon-120.png" sizes="120x120"> <!-- iPhone retina touch icon -->
    <link rel="apple-touch-icon" type="image/png" href="/dist/images/favicon-76.png" sizes="76x76"> <!-- iPad home screen icons -->
    <!-- Favicon Fallbacks for old browsers that don't read .ico -->
    <link rel="icon" type="image/png" href="/dist/images/favicon_32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/dist/images/favicon_16x16.png" sizes="16x16">
    <meta name="msapplication-TileColor" content="#e61428">
    <meta name="msapplication-TileImage" content="/dist/images/favicon-144.png">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if IE]>
    <script>var de = document.documentElement; de.className = de.className.replace('not-ie','ie');</script>
    <![endif]-->

    {{-- @include('partials._head_js') --}}
    <link href="{{ revAsset('styles/app.css') }}" rel="stylesheet" />
</head>

<body>
    {{-- <div class="svg-sprite">{!! File::exists(trim(revAsset('icons/icons.svg'), "/")) ? File::get(trim(revAsset('icons/icons.svg'), "/")) : '' !!}</div> --}}

    {{-- <div class="progress-bar" data-progress-bar></div> --}}

    @include('partials._header')

    @include('partials._search')

    <div class="wrapper">
        <main class="content">
            @yield('content')

            @include('partials._footer')
        </main>
    </div>

    <div class="modals" data-modal-container></div>

    @include('partials._templates')

    <script src="{{ revAsset('scripts/app.js') }}"></script>

    @unless (app()->environment('ipc','production'))
        @include('partials._design_grid')
        <script>A17.debug = true;</script>
    @endunless
    @unless(app()->environment(['development', 'local']))
        @php($ga_key = config('services.google.analytics_key'))
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
            ga('create', '{{ $ga_key or 'no key' }}', 'auto');
            ga('send', 'pageview');
        </script>
    @endunless
</body>
</html>
@endif
