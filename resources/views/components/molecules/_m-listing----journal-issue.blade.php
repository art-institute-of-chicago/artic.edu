{{-- PUB-146: Used to show journal issue on Writings --}}
<{{ $tag ?? 'li' }} class="m-listing m-listing--article{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('issues.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img">
            @if (isset($image) || $item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $image ?? $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
            <span class="m-listing__img__overlay"></span>
        </span>
        <div class="m-listing__meta">
            <em class="type f-tag">{!! $subtype ?? $item->present()->subtype !!}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            <br>
            @if ($item->present()->list_description)
                <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->present()->list_description !!}</div>
            @endif
        </div>
    </a>
</{{ $tag ?? 'li' }}>
