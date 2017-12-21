<ul class="m-link-list{{ (isset($variation)) ? ' '.$variation : '' }}">
    @foreach ($links as $link)
    <li class="m-link-list__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        <a class="m-link-list__trigger {{ $font ?? 'f-secondary' }}" href="{{ $link['href'] }}">{{ $link['label'] }}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a>
        @if (isset($link['links']))
            <ul class="m-link-list__sub-list">
                @foreach ($link['links'] as $sublink)
                    <li class="m-link-list__item{{ (isset($sublink['active']) and $sublink['active']) ? ' s-active' : '' }}">
                        <a class="m-link-list__trigger {{ $sublinkFont ?? 'f-secondary' }}" href="{{ $sublink['href'] }}">{{ $sublink['label'] }}@if (isset($sublink['icon']) and $sublink['icon'])<svg aria-hidden="true" class="{{ $sublink['icon'] }}"><use xlink:href="#{{ $sublink['icon'] }}" /></svg>@endif</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
    @endforeach
</ul>
