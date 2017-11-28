<ul class="m-link-list f-secondary">
    @foreach ($links as $link)
    <li class="m-link-list__item"><a class="m-link-list__trigger" href="{{ $link['href'] }}">{{ $link['text'] }}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a></li>
    @endforeach
</ul>
