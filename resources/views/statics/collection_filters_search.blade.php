@if( !empty( $links ) )
    @foreach ($links as $link)
      <li>
          <a href="{{ $link['href'] }}" class="checkbox f-secondary {{ $link['enabled'] ? 's-checked' : '' }}" data-ajax-scroll-target="collection">
              {{ $link['label'] }} @unless(isset($link['disableCount'])) <em>({{ $link['count'] }})</em> @endunless
          </a>
      </li>
    @endforeach
@endif
