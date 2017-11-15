<nav class="m-tabs">
  <ul class="m-tabs__items f-module-title-1">
    @foreach ($links as $link)
    <li class="m-tabs__item{{ ($link['active']) ? ' s-active' : '' }}"><a class="m-tabs__item-trigger" href="{{ $link['href'] }}">{{ $link['text'] }}</a></li>
    @endforeach
  </ul>
</nav>
