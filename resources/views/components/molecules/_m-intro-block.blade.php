<div class="m-intro-block{{ (isset($variation)) ? ' '.$variation : '' }}">
  <p class="m-intro-block__intro {{ $font ?? 'f-deck' }}"{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>{!! $slot !!}</p>
  @if (isset($links))
  <ul class="m-intro-block__links">
    @foreach ($links as $link)
    <li class="m-intro-block__link{{ (isset($link['variation']) and $link['variation'] === 'btn') ? ' m-intro-block__link--btn' : '' }}{{ (isset($link['active']) and $link['active']) ? ' s-active' : '' }}">
        <a class="m-intro-block__link-trigger {{ $link['font'] ?? 'f-buttons' }}{{ (isset($link['variation']) and $link['variation']) ? ' '.$link['variation'] : '' }}" href="{{ $link['href'] }}"{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>
          {!! $link['label'] !!}
          @if (isset($link['icon']) and $link['icon'])<svg aria-hidden="true" class="{{ $link['icon'] }}"><use xlink:href="#{{ $link['icon'] }}" /></svg>@endif
        </a>
    </li>
    @endforeach
  </ul>
  @endif
</div>
