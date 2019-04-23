@if (isset($title))
    <h3 class="sr-only" id="h-{{ Str::slug($title) }}">{{ $title }}</h3>
@endif
  <ul{!! (isset($id)) ? ' id="'.$id.'"' : '' !!} class="o-pinboard{!! (isset($variation)) ? ' '.$variation : '' !!}{!! (isset($cols_xsmall) and $cols_xsmall !== '') ? ' o-pinboard--'.$cols_xsmall.'-col@xsmall' : '' !!}{!! (isset($cols_small) and $cols_small !== '') ? ' o-pinboard--'.$cols_small.'-col@small' : '' !!}{!! (isset($cols_medium) and $cols_medium !== '') ? ' o-pinboard--'.$cols_medium.'-col@medium' : '' !!}{!! (isset($cols_large) and $cols_large !== '') ? ' o-pinboard--'.$cols_large.'-col@large' : '' !!}{!! (isset($cols_xlarge) and $cols_xlarge !== '') ? ' o-pinboard--'.$cols_xlarge.'-col@xlarge' : '' !!}" data-behavior="pinboard"{!! (isset($maintainOrder)) ? ' data-pinboard-maintain-order="'.$maintainOrder.'"' : '' !!}{!! (isset($optionLayout)) ? ' data-pinboard-option-layout="'.$optionLayout.'"' : '' !!}{!! isset($title) ? ' aria-labelledby="h-'.Str::slug($title).'"' : ''!!}>
    {!! $slot !!}
</ul>
