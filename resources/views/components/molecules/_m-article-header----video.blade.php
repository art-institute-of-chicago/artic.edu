<{{ $tag ?? 'header' }} class="m-article-header m-article-header--default{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (!empty($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('itemprop','name')
            @slot('title', $title)
            @slot('title_display', $title_display ?? null)
        @endcomponent
    @endif

    <div class="o-article__primary-actions o-article__primary-actions--video">
        @component('components.molecules._m-article-actions')
            @slot('articleType', 'video')
        @endcomponent
    </div>
</{{ $tag ?? 'header' }}>
