@if (isset($title))
    <h3 class="sr-only" id="h-{{ Str::slug($title) }}">{{ $title }}</h3>
@endif
  <ul{!! (isset($id)) ? ' id="'.$id.'"' : '' !!} class="o-gridboard{!! (isset($variation)) ? ' '.$variation : '' !!}{!! (isset($cols_xsmall) and $cols_xsmall !== '') ? ' o-gridboard--'.$cols_xsmall.'-col@xsmall' : '' !!}{!! (isset($cols_small) and $cols_small !== '') ? ' o-gridboard--'.$cols_small.'-col@small' : '' !!}{!! (isset($cols_medium) and $cols_medium !== '') ? ' o-gridboard--'.$cols_medium.'-col@medium' : '' !!}{!! (isset($cols_large) and $cols_large !== '') ? ' o-gridboard--'.$cols_large.'-col@large' : '' !!}{!! (isset($cols_xlarge) and $cols_xlarge !== '') ? ' o-gridboard--'.$cols_xlarge.'-col@xlarge' : '' !!}" data-behavior="gridboard"{!! (isset($optionLayout)) ? ' data-gridboard-option-layout="'.$optionLayout.'"' : '' !!}{!! isset($title) ? ' aria-labelledby="h-'.Str::slug($title).'"' : ''!!}>
    {!! $slot !!}
</ul>
