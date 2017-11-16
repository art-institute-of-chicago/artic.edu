<nav class="m-tabs-primary">
  @if (isset($linksPrimary) and $linksPrimary)
  <ul class="m-tabs-primary__items-primary f-module-title-1">
    @foreach ($linksPrimary as $link)
    <li class="m-tabs-primary__item-primary{{ ($link['active']) ? ' s-active' : '' }}"><a class="m-tabs-primary__item-primary-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
  @endif
  @if (isset($linksSecondary) and $linksSecondary)
  <ul class="m-tabs-primary__items-secondary f-buttons">
    @foreach ($linksSecondary as $link)
    <li class="m-tabs-primary__item-secondary"><a class="m-tabs-primary__item-secondary-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
  @endif
</nav>
