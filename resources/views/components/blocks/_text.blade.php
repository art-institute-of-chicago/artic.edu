@php
    $slot = preg_replace('/<p\b[^>]*>/i', '', $slot);
    $slot = str_ireplace('</p>', '', $slot);
@endphp
<{{ $tag ?? 'p' }} class="{{ $font ?? 'f-body' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($id)) ? ' id="'.$id.'"' : '' !!}{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>{!! $slot !!}</{{ $tag ?? 'p' }}>
