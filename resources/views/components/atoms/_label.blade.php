<label for="{{ $for ?? '' }}" class="{{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot ?? '' }}</label>
