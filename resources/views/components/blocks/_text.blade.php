<{{ $tag ?? 'p' }} class="{{ $font ?? 'f-body' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>{!! $slot !!}</{{ $tag ?? 'p' }}>
