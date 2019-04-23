<{{ $tag ?? 'header' }} class="m-header-block">
  <h1 class="title f-display-1"{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>{!! $slot !!}</h1>
</{{ $tag ?? 'header' }}>
