<{{ $tag ?? 'li' }} class="m-listing m-listing--hover-bar{{ (!$item->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if ($item->id)
  <a href="{{ route('exhibitions.history.show', $item) }}" class="m-listing__link">
  @endif
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->imageFront())
            @component('components.atoms._img')
                @slot('image', $item->imageFront())
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
        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->short_description }}</span>
        <br>
        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
            @endcomponent
        </span>
    </span>
  @if ($item->id)
  </a>
  @endif
</{{ $tag ?? 'li' }}>
