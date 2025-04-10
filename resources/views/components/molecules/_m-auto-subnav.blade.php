@if(!empty($subnav))
    <ul>
        @foreach($subnav as $navItem)
                <li class="m-links-bar__item"><a class="m-links-bar__item-trigger f-link" href="{!! Str::lower($navItem['target']) !!}">{!! Str::ucfirst(($navItem['label'])) !!}</a></li>
        @endforeach
    </ul>
@endif