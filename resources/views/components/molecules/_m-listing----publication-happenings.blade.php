<{{ $tag ?? 'li' }} class="m-listing m-listing--publication m-listing--publication-happenings m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <span class="m-listing__meta">
        @component('components.atoms._type')
            Calendar
            <br>
        @endcomponent
        @if (isset($title))
            @component('components.atoms._title')
                @slot('font', 'f-headline')
                @slot('title', $title)
                @slot('itemprop', 'name')
            @endcomponent
        @endif
        <br>
        @if (isset($items))
            <div class="m-listing--publication-happenings__items">
                @foreach($items as $item)
                    <a class="m-listing--publication-happenings__item" href="{!! $item['href'] ?? '' !!}" {!! $item['gtmAttributes'] ? $item['gtmAttributes'] : '' !!}>
                        <div class="f-tag">{!! $item['dateDisplay'] ?? '' !!}</div>
                        <div class="f-module-title-1">{!! $item['title'] ?? '' !!}</div>
                    </a>
                @endforeach
            </div>
        @endif
        <span class="m-listing__meta-bottom">
            @if (isset($btnText))
                <a class="btn f-buttons btn--publication-happening" {!! isset($gtmAttributes) ? $gtmAttributes : '' !!} href="{!! $btnHref ?? '' !!}">{{ $btnText }}</a>
            @endif
        </span>
    </span>
</{{ $tag ?? 'li' }}>
