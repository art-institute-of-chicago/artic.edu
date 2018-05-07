<blockquote class="quote{{ (isset($variation)) ? ' '.$variation : '' }}">
    <p class="{{ $font ?? 'f-quote' }}">{{ $slot }}</p>
    <svg class="quote__icon icon--quote--68 u-show@small+" aria-hidden="true"><use xlink:href="#icon--quote--68" /></svg>
    <svg class="quote__icon icon--quote--48 u-show@xsmall" aria-hidden="true"><use xlink:href="#icon--quote--48" /></svg>
</blockquote>
