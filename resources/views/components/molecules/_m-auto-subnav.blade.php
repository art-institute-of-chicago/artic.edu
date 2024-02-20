@if(!empty($subnav))
    <ul>
        @foreach($subnav as $item)
                <li class="m-links-bar__item"><a class="m-links-bar__item-trigger f-link" href="#{!! Str::slug(strip_tags($item)) !!}">{{ strip_tags(Str::ucfirst($item)) }}</a></li>
        @endforeach
    </ul>
@endif