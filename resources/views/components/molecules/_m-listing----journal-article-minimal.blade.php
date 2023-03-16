{{-- PUB-146: Used to show journal article on Writings --}}
<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('issue-articles.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img">
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
            @if ($item->present()->subtype)
                <em class="type f-tag">{!! $item->present()->subtype !!}</em>
                <br>
            @endif
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{!! $item->present()->title_display ?? $item->present()->title !!}</strong>
            <br>
            @if ($item->showAuthors())
                <span class="m-listing__meta-bottom">
                    <span class="f-secondary">{{ $item->showAuthors() }}</span>
                </span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
