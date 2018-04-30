<div class="m-title-bar {{ $variation ?? '' }}"{!! isset($id) ? ' id="'.$id.'"' : '' !!}>
  <h2 class="title {{ $titleFont ?? 'f-module-title-2' }}">{{ $slot }}</h2>
  @if (isset($links) and $links)
  <ul class="m-title-bar__links">
    @foreach ($links as $link)
    <li>
        @if (isset($link['href']))
        <a href="{{ $link['href'] }}" class="f-link"{!! (isset($link['dataAttributes'])) ? ' '.$link['dataAttributes'] : '' !!}>
            {!! $link['label'] ?? '' !!}&nbsp;&nbsp;&rsaquo;
        </a>
        @else
            <span class="f-secondary">{!! $link['label'] ?? '' !!}</span>
        @endif
    </li>
    @endforeach
  </ul>
  @endif
</div>
