<{{ $tag ?? 'li' }} class="m-listing{{ (!$exhibition->slug) ? ' s-no-link' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if ($exhibition->slug)
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
  @endif
    <span class="m-listing__img m-listing__img--wide">
        @if ($exhibition->image)
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
            @slot('srcset', $exhibition->image['srcset'])
            @slot('width', $exhibition->image['width'])
            @slot('height', $exhibition->image['height'])
        @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $exhibition->title }}
        @endcomponent
        <br>
        <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $exhibition->intro }}</span>
        <br>
        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                {{ $exhibition->date }}
            @endcomponent
        </span>
    </span>
  @if ($exhibition->slug)
  </a>
  @endif
</{{ $tag ?? 'li' }}>
