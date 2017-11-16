<nav class="m-tabs-secondary">
  @if (isset($linksPrimary) and $linksPrimary)
  <ul class="m-tabs-secondary__items-primary f-buttons">
    @foreach ($linksPrimary as $link)
    <li class="m-tabs-secondary__item-primary{{ ($link['active']) ? ' s-active' : '' }}"><a class="m-tabs-secondary__item-primary-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
  @endif
  @if (isset($linksSecondary) and $linksSecondary)
  <ul class="m-tabs-secondary__items-secondary f-buttons">
    @foreach ($linksSecondary as $link)
    <li class="m-tabs-secondary__item-secondary"><a class="m-tabs-secondary__item-secondary-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
  @endif
</nav>
