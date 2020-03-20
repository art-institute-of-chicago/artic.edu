@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----journal')
        @slot('title', $item->present()->title ?? null)
        @slot('title_display', $item->present()->title_display ?? null)
        @slot('img', $item->imageFront('hero') ?? null)
        @slot('credit', $item->hero_caption ?? null)
        @slot('intro', $item->header_text ?? null)
        @slot('issueNumber', $item->issue_number ?? null)
    @endcomponent

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->getEditorsNote())
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note')
                    @slot('title', $item->getEditorsNote()->present()->shortTitle)
                    @slot('description', $item->getEditorsNote()->present()->listDescription)
                    @slot('issueNumber', $item->issue_number ?? null)
                    @slot('articleLink', 'TODO')
                @endcomponent
            </div>
        @endif
    </div>

</article>

@endsection
