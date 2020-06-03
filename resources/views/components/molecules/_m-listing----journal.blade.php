<{{ $tag ?? 'li' }} class="m-listing m-listing--journal m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $href ?? '' }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img">
        @if ($image)
            @component('components.atoms._img')
                @slot('image', $image)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            <span class="default-img"></span>
        @endif
        <span class="m-listing__img__overlay"></span>
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._type')
            {!! $type !!}
        @endcomponent
        <br>
        @component('components.atoms._title')
            @slot('font', 'f-list-3')
            @slot('title', $title)
            @slot('title_display', $title_display)
            @slot('itemprop', 'name')
        @endcomponent
        <br>
        @if ($list_description)
            @component('components.atoms._short-description')
                @slot('font', 'f-body-editorial')
                {!! $list_description !!}
            @endcomponent
        @endif
        <br>
        @if ($author_display)
            <span class="m-listing__meta-bottom">
                <span class="f-tag">{{ $author_display }}</span>
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
