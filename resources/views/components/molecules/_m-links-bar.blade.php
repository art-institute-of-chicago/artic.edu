@php
    $linksPrimaryFontClass = ' f-buttons';
    $linksPrimaryFontClass = (isset($variation) and $variation === 'm-links-bar--buttons') ? ' btn f-buttons' : $linksPrimaryFontClass;
    $linksPrimaryFontClass = (isset($variation) and $variation === 'm-links-bar--tabs') ? ' f-module-title-2' : $linksPrimaryFontClass;
@endphp
<nav class="m-links-bar{{ (isset($variation) and $variation) ? " ".$variation : "" }}">
@if (isset($linksPrimary) and $linksPrimary)
  <ul class="m-links-bar__items-primary">
    @foreach ($linksPrimary as $link)
    <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        <a class="m-links-bar__item-trigger{{ $linksPrimaryFontClass }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">
          @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'm-links-bar--buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
          {{ $link['text'] }}
          @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'm-links-bar--buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
        </a>
    </li>
    @endforeach
    @if ($slot and strlen($slot) > 0)
        <li class="m-links-bar__item">{{ $slot }}</li>
    @endif
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
