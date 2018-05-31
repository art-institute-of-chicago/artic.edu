<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom m-listing--hover-bar{{ (!$item->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">

  <a href="{{ route('exhibitions.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            <span class="default-img"></span>
        @endif
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $item->title }}
        @endcomponent

        <br>
        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->list_description }}</span>
        <br>

        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                @if (!empty($item->present()->formattedDate))
                    {!! $item->present()->formattedDate !!}
                @elseif ($item->dateStart and $item->dateEnd)
                    {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
                @endif
            @endcomponent
        </span>
    </span>
  </a>

</{{ $tag ?? 'li' }}>
