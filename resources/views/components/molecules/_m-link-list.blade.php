<ul class="m-link-list{{ (isset($variation)) ? ' '.$variation : '' }}">
    @foreach ($links as $link)
    <li class="m-link-list__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        @if (isset($link['href']))
        <a class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">
            @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
            {{ $link['label'] }}
            @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
        </a>
        @else
        <span class="m-link-list__trigger {{ $font ?? 'f-secondary' }}{{ (isset($link['variation'])) ? ' '.$link['variation'] : '' }}">
            @if (isset($link['iconBefore']) and $link['iconBefore'])<svg aria-hidden="true" class="icon--{{ $link['iconBefore'] }}"><use xlink:href="#icon--{{ $link['iconBefore'] }}" /></svg>@endif
            {{ $link['label'] }}
            @if (isset($link['iconAfter']) and $link['iconAfter'])<svg aria-hidden="true" class="icon--{{ $link['iconAfter'] }}"><use xlink:href="#icon--{{ $link['iconAfter'] }}" /></svg>@endif
        </span>
        @endif
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
