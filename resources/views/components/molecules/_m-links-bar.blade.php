@php
    $linksPrimaryFontClass = ' f-buttons';
    $isTabs = (isset($variation) and $variation === 'm-links-bar--tabs');
    $linksPrimaryFontClass = (isset($variation) and $variation === 'm-links-bar--buttons') ? ' btn f-buttons' : $linksPrimaryFontClass;
    $linksPrimaryFontClass = ($isTabs) ? ' f-module-title-2' : $linksPrimaryFontClass;
    $activePrimaryLink = false;
    if (isset($linksPrimary)) {
        for ($i = 0; $i < count($linksPrimary); $i++) {
            if (isset($linksPrimary[$i]['active']) && $linksPrimary[$i]['active']) {
                $activePrimaryLink = $i;
            }
        }
    }
@endphp
<nav class="m-links-bar{{ (isset($variation) and $variation) ? " ".$variation : "" }}"{!! (isset($overflow) and $overflow) ? ' data-behavior="linksBar"' : '' !!}>
  @if ((isset($linksPrimary) and $linksPrimary) or (isset($primaryHtml) and $primaryHtml))
    <ul class="m-links-bar__items-primary{{ (isset($primaryVariation) and $primaryVariation) ? ' '.$primaryVariation : '' }}" data-links-bar-primary>
      @if (isset($linksPrimary) and $linksPrimary)
          @foreach ($linksPrimary as $link)
          <li class="m-links-bar__item{{ (isset($link['liVariation']) and $link['liVariation']) ? ' '.$link['liVariation'] : '' }}{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
              <a class="m-links-bar__item-trigger{{ $linksPrimaryFontClass }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}" {!! (isset($link['loadMoreUrl']) and $link['loadMoreUrl']) ? 'data-behavior="loadMore" data-load-more-url="'. $link['loadMoreUrl'] .'"' : '' !!} {!! (isset($link['loadMoreTarget']) and $link['loadMoreTarget']) ? 'data-load-more-target="'. $link['loadMoreTarget'] .'"' : '' !!}>
                @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'm-links-bar--buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
                {!! $link['label'] !!}
                @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'm-links-bar--buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
              </a>
          </li>
          @endforeach
          @if (isset($overflow) and $overflow)
          <li class="m-links-bar__item m-links-bar__item--push m-links-bar__item--overflow s-hidden" data-links-bar-primary-overflow>
              @component('components.atoms._dropdown')
                @slot('prompt', ($isTabs && $activePrimaryLink > -1 ? $linksPrimary[$activePrimaryLink]['label'] : "More"))
                @slot('ariaTitle', 'More links')
                @slot('variation','dropdown--filter '.$linksPrimaryFontClass)
                @slot('font', $linksPrimaryFontClass)
                @slot('options', $linksPrimary)
              @endcomponent
          </li>
          @endif
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
              <a class="m-links-bar__item-trigger{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : ' f-buttons' }}" href="{{ $link['href'] }}">{!! $link['label'] !!}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a>
          </li>
          @endforeach
      @endif
      @if (isset($secondaryHtml) and $secondaryHtml)
          {{ $secondaryHtml }}
      @endif
    </ul>
  @endif
</nav>
