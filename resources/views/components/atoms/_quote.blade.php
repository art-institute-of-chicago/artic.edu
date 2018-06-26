<blockquote class="quote{{ (isset($variation)) ? ' '.$variation : '' }}">
    <p class="{{ $font ?? 'f-quote' }}">{{ $slot }}</p>

    @if ( !empty( $attribution ) )
        <cite class="f-secondary">{{ $attribution }}</cite>
    @endif

    <svg class="quote__icon" aria-hidden="true">
        <use xlink:href="#icon--quote--48" />
        <use xlink:href="#icon--quote--68" />
        <use xlink:href="#icon--quote--76" />
    </svg>
</blockquote>
