<blockquote class="quote{{ (isset($variation)) ? ' '.$variation : '' }}">
    <p class="{{ $font ?? 'f-quote' }}">{{ $slot }}</p>
    <svg class="quote__icon icon--quote--68" aria-hidden="true"><use xlink:href="#icon--quote--68" /></svg>
</blockquote>
