<{{ $tag ?? 'li' }} class="m-listing m-listing--journal m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ route('issue-articles.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img">
        @if ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            <span class="default-img"></span>
        @endif
        <span class="m-listing__img__overlay"></span>
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._type')
            {!! $item->present()->type !!}
        @endcomponent
        <br>
        @component('components.atoms._title')
            @slot('font', 'f-list-3')
            @slot('title', $item->present()->title)
            @slot('title_display', $item->present()->title_display)
            @slot('itemprop', 'name')
        @endcomponent
        <br>
        @if ($item->present()->list_description)
            @component('components.atoms._short-description')
                @slot('font', 'f-body-editorial')
                {!! $item->present()->list_description !!}
            @endcomponent
        @endif
        <br>
        @if ($item->author_display)
            <span class="m-listing__meta-bottom">
                <span class="f-tag">{{ $item->author_display }}</span>
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
