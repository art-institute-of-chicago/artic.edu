<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
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
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">
                    @if (!empty($item->date))
                        {{ $item->date->format('F j, Y') }}
                    @endif
                </span>
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
