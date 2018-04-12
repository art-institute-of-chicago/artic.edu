<{{ $tag ?? 'li' }} class="m-listing m-listing--hover-bar{{ (!$item->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if ($item->slug)
  <a href="{{ route('exhibitions.history.show', $item) }}" class="m-listing__link">
  @endif
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $item->title }}
        @endcomponent
        <br>
        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->listing_description }}</span>
        <br>
        <span class="m-listing__meta-bottom">
            @if (isset($formattedDate))
              @component('components.atoms._date')
                  {!! $formattedDate !!}
              @endcomponent
            @elseif (isset($date))
              @component('components.atoms._date')
                  @slot('tag','p')
                  {{ $date->format('F j, Y') }}
              @endcomponent
            @endif
        </span>
    </span>
  @if ($item->slug)
  </a>
  @endif
</{{ $tag ?? 'li' }}>
