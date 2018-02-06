<{{ $tag ?? 'li' }} class="m-listing{{ (!$item->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if ($item->slug)
  <a href="{{ $item->slug }}" class="m-listing__link">
  @endif
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->image)
            @component('components.atoms._img')
                @slot('src', $item->image['src'])
                @slot('srcset', $item->image['srcset'])
                @slot('width', $item->image['width'])
                @slot('height', $item->image['height'])
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $item->title }}
        @endcomponent
        <br>
        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->intro }}</span>
        <br>
        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                {{ date( 'F j, Y', intval($item->date)) }}
            @endcomponent
        </span>
    </span>
  @if ($item->slug)
  </a>
  @endif
</{{ $tag ?? 'li' }}>
