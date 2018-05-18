<ul class="m-link-list{{ (isset($variation)) ? ' '.$variation : '' }}">
    @foreach ($links as $link)
    <li class="m-link-list__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        @if (isset($variation) && strrpos($variation, "--download"))
            <a class="m-link-list__trigger{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}" href="{{ $link['link'] }}">
                <span class="m-link-list__trigger-file-name {{ $font ?? 'f-secondary' }}">
                @if (isset($link['name']))
                    {{ $link['name'] }}
                @endif
                </span>
                <span class="m-link-list__trigger-file-meta {{ $font ?? 'f-secondary' }}">
                @if (isset($link['extension']))
                    {{ strtoupper($link['extension']) }}@if (isset($link['size'])){{ ', '}}@endif
                @endif
                @if (isset($link['size']))
                    {{ $link['size'] }}
                @endif
                </span>
                <svg class="icon--download--24"><use xlink:href="#icon--download--24" /></svg>
            </a>
        @else
            @if (isset($link['href']))
            <a class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">
                @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="m-link-list__icon-before icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
                <span class="m-link-list__label">{!! $link['label'] !!}</span>
                @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="m-link-list__icon-after icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
            </a>
            @else
            <span class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}">
                @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="m-link-list__icon-before icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
                <span class="m-link-list__label">{!! $link['label'] !!}</span>
                @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="m-link-list__icon-after icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
            </span>
            @endif
            @if (isset($link['links']))
                <ul class="m-link-list__sub-list">
                    @foreach ($link['links'] as $sublink)
                        <li class="m-link-list__item{{ (isset($sublink['active']) and $sublink['active']) ? ' s-active' : '' }}">
                            <a class="m-link-list__trigger {{ $sublinkFont ?? 'f-secondary' }}" href="{{ $sublink['href'] }}"><span class="m-link-list__label">{{ $sublink['label'] }}</span>@if (isset($sublink['icon']) and $sublink['icon'])<svg aria-hidden="true" class="{{ $sublink['icon'] }}"><use xlink:href="#{{ $sublink['icon'] }}" /></svg>@endif</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </li>
    @endforeach
</ul>
