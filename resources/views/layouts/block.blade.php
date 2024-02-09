@php
use Illuminate\Support\Facades\App;
$print = app('printservice')->isPrintMode();
$pClass = 'App\Http\Controllers\GenericPagesController';
if (!App::environment('testing')) {
    $action = request()->route()->getAction();
    if (is_array($action) && $action['controller']) {
        $pClass = $action['controller'];
    }
}
$pClass = preg_replace('/App\\\\Http\\\\Controllers\\\\/i','p-',$pClass);
$pClass = preg_replace('/Controller/i','',$pClass);
$pClass = strtolower(preg_replace('/@/i','-',$pClass));
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="en-US" class="no-js{{ (isset($contrastHeader) and $contrastHeader) ? ' s-contrast-header' : '' }}{{ (isset($filledLogo) and $filledLogo) ? ' s-filled-logo' : '' }}{{ $print ? ' s-print' : '' }}  {{ !empty($modal) ? 's-modal-active' : '' }}  {{ $pClass }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="format-detection" content="telephone=no">

  <title>AIC</title>

  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->

  <meta name="svg-sprite-src" content="{{ FrontendHelpers::revAsset('icons/icons.svg') }}">

  @include('partials._head-js')
  <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/612324/7579192/css/fonts.css" />
  <style>
  @import url("//hello.myfonts.net/count/3545d5");
  @font-face {font-family: 'Sabon';src: url({{FrontendHelpers::revAsset('fonts/3545D5_0_0.woff2')}}) format('woff2');font-weight:normal;font-weight:400;font-style:normal;}
  @font-face {font-family: 'Sabon';src: url({{FrontendHelpers::revAsset('fonts/3545D5_1_0.woff2')}}) format('woff2');font-weight:normal;font-weight:400;font-style:italic;}
  @font-face {font-family: 'Sabon';src: url({{FrontendHelpers::revAsset('fonts/3545D5_2_0.woff2')}}) format('woff2');font-weight:normal;font-weight:500;font-style:normal;}
  </style>
  <link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet" />
</head>

<body>

<div id="a17">
  <main id="content">
    <article class="o-article">
      <div class="o-article__body o-blocks">
        @yield('content')
      </div>
    </article>
  </main>
</div>

@include('partials._scripts')
</body>
</html>
