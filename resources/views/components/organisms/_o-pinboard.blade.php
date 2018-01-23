<ul class="o-pinboard{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($cols_xsmall) and $cols_xsmall !== '') ? ' o-pinboard--'.$cols_xsmall.'-col@xsmall' : '' }}{{ (isset($cols_small) and $cols_small !== '') ? ' o-pinboard--'.$cols_small.'-col@small' : '' }}{{ (isset($cols_medium) and $cols_medium !== '') ? ' o-pinboard--'.$cols_medium.'-col@medium' : '' }}{{ (isset($cols_large) and $cols_large !== '') ? ' o-pinboard--'.$cols_large.'-col@large' : '' }}{{ (isset($cols_xlarge) and $cols_xlarge !== '') ? ' o-pinboard--'.$cols_xlarge.'-col@xlarge' : '' }}{{ (isset($cols_xxlarge) and $cols_xxlarge !== '') ? ' o-pinboard--'.$cols_xxlarge.'-col@xxlarge' : '' }}" data-behavior="pinboard"{{ (isset($maintainOrder)) ? ' data-pinboard-maintain-order="'.$maintainOrder.'"' : '' }}>
    {{ $slot }}
</ul>

@if ( !empty( $moreLink ) )
    <div class="o-pinboard__footer">
        <a href="{{ $moreLink->url }}" class="f-buttons btn btn--secondary">{{ $moreLink->text }}</a>
    </div>
@endif
