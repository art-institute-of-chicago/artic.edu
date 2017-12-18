@php
    $linksPrimaryFontClass = ' f-buttons';
    $linksPrimaryFontClass = (isset($variation) and $variation === 'm-links-bar--buttons') ? ' btn f-buttons' : $linksPrimaryFontClass;
    $linksPrimaryFontClass = (isset($variation) and $variation === 'm-links-bar--tabs') ? ' f-module-title-2' : $linksPrimaryFontClass;
@endphp
<nav class="m-links-bar{{ (isset($variation) and $variation) ? " ".$variation : "" }}">
@if ((isset($linksPrimary) and $linksPrimary) or (isset($primaryHtml) and $primaryHtml))
  <ul class="m-links-bar__items-primary{{ (isset($primaryVariation) and $primaryVariation) ? ' '.$primaryVariation : '' }}">
    @if (isset($linksPrimary) and $linksPrimary)
        @foreach ($linksPrimary as $link)
        <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
            <a class="m-links-bar__item-trigger{{ $linksPrimaryFontClass }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">
              @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'm-links-bar--buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
              {{ $link['text'] }}
              @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'm-links-bar--buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
            </a>
        </li>
        @endforeach
    @endif
    @if (isset($primaryHtml) and $primaryHtml)
        {{ $primaryHtml }}
    @endif
  </ul>
@endif
@if ((isset($linksSecondary) and $linksSecondary) or (isset($secondaryHtml) and $secondaryHtml))
  <ul class="m-links-bar__items-secondary{{ (isset($secondaryVariation) and $secondaryVariation) ? ' '.$secondaryVariation : '' }}">
    @if (isset($linksSecondary) and $linksSecondary)
        @foreach ($linksSecondary as $link)
        <li class="m-links-bar__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
            <a class="m-links-bar__item-trigger{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : ' f-buttons' }}" href="{{ $link['href'] }}">{{ $link['text'] }}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a>
        </li>
        @endforeach
    @endif
    @if (isset($secondaryHtml) and $secondaryHtml)
        {{ $secondaryHtml }}
    @endif
  </ul>
@endif
</nav>
