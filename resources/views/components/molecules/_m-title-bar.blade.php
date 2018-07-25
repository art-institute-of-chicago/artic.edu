<div class="m-title-bar {{ $variation ?? '' }}"{!! isset($id) ? ' id="'.$id.'"' : '' !!}>
  <h2 class="title {{ $titleFont ?? 'f-module-title-2' }}">{{ $slot }}</h2>
  @if (isset($links) and $links)
  <ul class="m-title-bar__links">
    @foreach ($links as $link)
    <li>
        @if (isset($link['href']))
        <a href="{{ $link['href'] }}" class="f-link"{!! (isset($link['dataAttributes'])) ? ' '.$link['dataAttributes'] : '' !!}{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>
            {!! $link['label'] ?? '' !!}{!! (!isset($link['dataAttributes'])) ? '<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>' : '' !!}
        </a>
        @else
            <span class="f-secondary">{!! $link['label'] ?? '' !!}</span>
        @endif
    </li>
    @endforeach
  </ul>
  @endif
</div>
