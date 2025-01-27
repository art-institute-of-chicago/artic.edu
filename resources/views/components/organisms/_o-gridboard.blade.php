<div id="pubs-grid" data-behavior="gridboard">
@if (isset($title))
    <h3 class="sr-only" id="h-{{ Str::slug($title) }}">{{ $title }}</h3>
@endif

  <button data-hash="110100000000010101000111001010000001110100001011010100011100011111110010111101001110111010000010001111101" class="o-gridboard__btn-random btn btn--tertiary f-buttons">Tag 1</button>
  <button data-hash="0001011101001101001001001011000101101111010000000000011110100010000010111011111010011010100101110110111" class="o-gridboard__btn-random btn btn--tertiary f-buttons">Tag 2</button>
  <button data-hash="111001110101100111111001010001111101100110110010000111000011010100110101001101111110011" class="o-gridboard__btn-random btn btn--tertiary f-buttons">Tag 3</button>
  <button data-hash="1011111111010111110111111010010011101101001110101000100110110001001010110110011011" class="o-gridboard__btn-random btn btn--tertiary f-buttons">Tag 4</button>
  <button data-hash="01101011010000111100100010011101011000100101000100000111011011001100001010001111001011101110000010010101011" class="o-gridboard__btn-random btn btn--tertiary f-buttons">Tag 5</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">1</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">2</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">3</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons" data-ajax-scroll-target="pubs-grid">4</button>

  <ul{!! (isset($id)) ? ' id="'.$id.'"' : '' !!} class="o-gridboard{!! (isset($variation)) ? ' '.$variation : '' !!}{!! (isset($cols_xsmall) and $cols_xsmall !== '') ? ' o-gridboard--'.$cols_xsmall.'-col@xsmall' : '' !!}{!! (isset($cols_small) and $cols_small !== '') ? ' o-gridboard--'.$cols_small.'-col@small' : '' !!}{!! (isset($cols_medium) and $cols_medium !== '') ? ' o-gridboard--'.$cols_medium.'-col@medium' : '' !!}{!! (isset($cols_large) and $cols_large !== '') ? ' o-gridboard--'.$cols_large.'-col@large' : '' !!}{!! (isset($cols_xlarge) and $cols_xlarge !== '') ? ' o-gridboard--'.$cols_xlarge.'-col@xlarge' : '' !!}" {!! isset($title) ? ' aria-labelledby="h-'.Str::slug($title).'"' : ''!!}>
    {!! $slot !!}
  </ul>
</div>
