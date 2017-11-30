@php
    $linksPrimaryFontClass = ' f-buttons';
    $linksPrimaryFontClass = (isset($variation) and $variation === 'buttons') ? ' btn f-buttons' : $linksPrimaryFontClass;
    $linksPrimaryFontClass = (isset($variation) and $variation === 'tabs') ? ' f-module-title-2' : $linksPrimaryFontClass;
@endphp
<nav class="m-links-bar{{ (isset($variation) and $variation) ? " m-links-bar--".$variation : "" }}">
@if (isset($linksPrimary) and $linksPrimary)
  <ul class="m-links-bar__items-primary">
    @foreach ($linksPrimary as $link)
    <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        <a class="m-links-bar__item-trigger{{ $linksPrimaryFontClass }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">
          @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
          {{ $link['text'] }}
          @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
        </a>
    </li>
    @endforeach
  </ul>
@endif
@if (isset($linksSecondary) and $linksSecondary)
  <ul class="m-links-bar__items-secondary">
    @foreach ($linksSecondary as $link)
    <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        <a class="m-links-bar__item-trigger{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : ' f-buttons' }}" href="{{ $link['href'] }}">{{ $link['text'] }}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a>
    </li>
    @endforeach
  </ul>
@endif
</nav>
