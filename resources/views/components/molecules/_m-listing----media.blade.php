<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $media->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--wide">
            @component('components.atoms._img')
                @slot('src', $media->image['src'])
                @slot('width', $media->image['width'])
                @slot('height', $media->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $media->title }}</strong>
            @if ($media->timeStamp)
            <br>
            <span class="subtitle f-secondary">{{ $media->timeStamp }}</span>
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
