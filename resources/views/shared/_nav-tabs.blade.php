<nav class="m-tabs{{ (isset($variation) and $variation) ? " m-tabs--".$variation : "" }}">
@if (isset($linksPrimary) and $linksPrimary)
  @if (isset($variation) and $variation === 'primary')
  <ul class="m-tabs__items-primary f-module-title-1">
  @else
  <ul class="m-tabs__items-primary f-buttons">
  @endif
    @foreach ($linksPrimary as $link)
    <li class="m-tabs__item{{ ($link['active']) ? ' s-active' : '' }}"><a class="m-tabs__item-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
@endif
@if (isset($linksSecondary) and $linksSecondary)
  <ul class="m-tabs__items-secondary f-buttons">
    @foreach ($linksSecondary as $link)
    <li class="m-tabs__item"><a class="m-tabs__item-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
@endif
</nav>
