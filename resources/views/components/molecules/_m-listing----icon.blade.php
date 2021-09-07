<{{ $tag ?? 'li' }} class="m-listing m-listing--icon{{ (isset($variation)) ? ' '.$variation : '' }}">
    <span class="m-listing__img m-listing__img--no-bg m-listing__img--icon">
        <svg aria-hidden="true">
            <use xlink:href="#icon--{{ ImageHelpers::aic_getIconClass($item['iconType']) }}" />
        </svg>
    </span>
    <span class="m-listing__meta">
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-body')
            @slot('title', $item['text'])
        @endcomponent
    </span>
</{{ $tag ?? 'li' }}>
