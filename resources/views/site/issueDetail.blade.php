@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----journal')
        @slot('title', $item->present()->title ?? null)
        @slot('title_display', $item->present()->title_display ?? null)
        @slot('img', $item->imageFront('hero') ?? null)
        @slot('intro', $item->header_text ?? null)
        @slot('issueNumber', $item->issue_number ?? null)
    @endcomponent

    <div class="o-article__primary-actions">
        @if ($item->articleType !== 'artwork')
            @component('components.molecules._m-article-actions')
                @slot('articleType', $item->articleType)
            @endcomponent
        @endif
    </div>

    <div class="o-article__secondary-actions{{ ($item->headerType === 'gallery') ? ' o-article__secondary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@medium+' : '' }}">
        @component('site.shared._featuredRelated')
            @slot('featuredRelated', $item->featuredRelated ?? null)
            @slot('variation', 'u-show@medium+')
        @endcomponent
    </div>

    @if ($item->heading)
        <div class="o-article__intro">
            @component('components.blocks._text')
                @slot('font', 'f-deck')
                @slot('tag', 'span')
                {!! $item->present()->heading !!}
            @endcomponent
        </div>
    @endif

    @if ($item->getEditorsNote())
        <div class="o-article__intro">
            @component('components.blocks._text')
                @slot('font', 'f-deck')
                @slot('tag', 'span')
                {{ $item->getEditorsNote()->title }} {!! $item->getEditorsNote()->description !!}
            @endcomponent
        </div>
    @endif

    <div class="o-article__body o-blocks">

    </div>

</article>

@endsection
