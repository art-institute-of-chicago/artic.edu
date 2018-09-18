@if (isset($title))
    <h3 class="sr-only" id="h-{{ str_slug($title) }}">{{ $title }}</h3>
@endif
<{{ $tag or 'ul' }} class="m-multi-col-list{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($cols_xsmall) and $cols_xsmall !== '') ? ' m-multi-col-list--'.$cols_xsmall.'-col@xsmall' : '' }}{{ (isset($cols_small) and $cols_small !== '') ? ' m-multi-col-list--'.$cols_small.'-col@small' : '' }}{{ (isset($cols_medium) and $cols_medium !== '') ? ' m-multi-col-list--'.$cols_medium.'-col@medium' : '' }}{{ (isset($cols_large) and $cols_large !== '') ? ' m-multi-col-list--'.$cols_large.'-col@large' : '' }}{{ (isset($cols_xlarge) and $cols_xlarge !== '') ? ' m-multi-col-list--'.$cols_xlarge.'-col@xlarge' : '' }}"{!! isset($title) ? ' aria-labelledby="h-'.str_slug($title).'"' : ''!!}>
    @unless (empty($items))
        @foreach ($items as $key => $label)
            <li class="f-link">
                <a href="{!! $key !!}">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    @endunless
</{{ $tag or 'ul' }}>
