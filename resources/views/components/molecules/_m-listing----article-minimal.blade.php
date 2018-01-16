<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $article->slug }}" class="m-listing__link">
        <span class="m-listing__img">
            @component('components.atoms._img')
                @slot('src', $article->image['src'])
                @slot('width', $article->image['width'])
                @slot('height', $article->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $article->subtype }}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $article->title }}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">{{ $article->date }}</span>
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
