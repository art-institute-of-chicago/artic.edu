<nav class="m-tabs{{ (isset($variation) and $variation) ? " m-tabs--".$variation : "" }}">
@if (isset($linksPrimary) and $linksPrimary)
  @if (isset($variation) and $variation === 'primary')
  <ul class="m-tabs__items-primary f-module-title-1">
  @elseif (isset($variation) and $variation === 'buttons')
  <ul class="m-tabs__items-primary">
  @else
  <ul class="m-tabs__items-primary f-buttons">
  @endif
    @foreach ($linksPrimary as $link)
    <li class="m-tabs__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}"><a class="m-tabs__item-trigger{{ (isset($variation) and $variation === 'buttons') ? ' btn' : '' }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">

      @if (isset($link['icon']) and $link['icon'] and isset($variation) and $variation === 'buttons')<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
      {{ $link['text'] }}
      @if (isset($link['icon']) and $link['icon'] and (!isset($variation) or $variation !== 'buttons'))<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif

    </a></li>
    @endforeach
  </ul>
@endif
@if (isset($linksSecondary) and $linksSecondary)
  <ul class="m-tabs__items-secondary f-buttons">
    @foreach ($linksSecondary as $link)
    <li class="m-tabs__item{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}"><a class="m-tabs__item-trigger{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}">{{ $link['text'] }}@if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif</a></li>
    @endforeach
  </ul>
@endif
</nav>
