<{{ $tag ?? 'p' }} class="{{ $font ?? 'f-body' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{!! $slot !!}</{{ $tag ?? 'p' }}>
