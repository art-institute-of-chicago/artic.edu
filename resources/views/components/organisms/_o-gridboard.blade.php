<div data-behavior="gridboard">
@if (isset($title))
    <h3 class="sr-only" id="h-{{ Str::slug($title) }}">{{ $title }}</h3>
@endif

  <button class="o-gridboard__btn-random btn btn--tertiary f-buttons">Show random 50</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">1</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">2</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">3</button>
  <button class="o-gridboard__btn-page btn btn--tertiary f-buttons">4</button>

  <ul{!! (isset($id)) ? ' id="'.$id.'"' : '' !!} class="o-gridboard{!! (isset($variation)) ? ' '.$variation : '' !!}{!! (isset($cols_xsmall) and $cols_xsmall !== '') ? ' o-gridboard--'.$cols_xsmall.'-col@xsmall' : '' !!}{!! (isset($cols_small) and $cols_small !== '') ? ' o-gridboard--'.$cols_small.'-col@small' : '' !!}{!! (isset($cols_medium) and $cols_medium !== '') ? ' o-gridboard--'.$cols_medium.'-col@medium' : '' !!}{!! (isset($cols_large) and $cols_large !== '') ? ' o-gridboard--'.$cols_large.'-col@large' : '' !!}{!! (isset($cols_xlarge) and $cols_xlarge !== '') ? ' o-gridboard--'.$cols_xlarge.'-col@xlarge' : '' !!}" {!! isset($title) ? ' aria-labelledby="h-'.Str::slug($title).'"' : ''!!}>
    {!! $slot !!}
  </ul>
</div>
