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
            <em class="type f-tag">Article</em>
            <br>
            <strong class="title f-list-3">{{ $article->title }}</strong>
            <br>
            <span class="intro f-caption">{{ $article->intro }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
