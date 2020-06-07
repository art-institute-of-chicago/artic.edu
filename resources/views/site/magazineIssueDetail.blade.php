@extends('layouts.app')

@section('content')

<article class="o-article">
    {{-- TODO: New header treatment --}}
    @if ($heroImage = $item->imageFront('hero') ?? null)
        @component('components.molecules._m-article-header----magazine')
            @slot('img', $heroImage)
            @slot('title', $item->present()->title ?? null)
            @slot('credit', $item->hero_caption ?? null)
            @slot('intro', $item->hero_text ?? null)
        @endcomponent
    @endif

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions----magazine-issue')
            @slot('issues', $issues)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($welcomeNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----magazine')
                    @slot('description', $item->welcome_note_display ?? $welcomeNote->present()->listDescription)
                    @slot('articleLink', $welcomeNote->present()->url)
                    @slot('authorDisplay', $welcomeNote->author_display ?? $welcomeNote->author);
                @endcomponent
            </div>
        @endif

        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--journal')
            @slot('cols_xsmall','1')
            @slot('cols_small','2')
            @slot('cols_medium','2')
            @slot('cols_large','2')
            @slot('cols_xlarge','2')

            {!! $item->renderBlocks(false) !!}
        @endcomponent
    </div>

</article>

<hr>

<div class="o-publication-footer o-publication-footer--magazine">
    <div class="o-publication-footer__logo">
      <svg class="icon--magazine-logo">
        <use xlink:href="#icon--magazine-logo"></use>
      </svg>
    </div>
    <div class="o-publication-footer__text">
        <p class="f-secondary">Become a member or renew your membership today. Receive access to exhibition previews, exclusive events, and free admission year-round. <a href="/support-us/membership">Learn more</a>.</p>
    </div>
</div>

@endsection
