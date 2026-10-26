<{{ $tag ?? 'p' }} class="{{ $font ?? 'f-body' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($id)) ? ' id="'.$id.'"' : '' !!}>{!! $slot !!}</{{ $tag ?? 'p' }}>
