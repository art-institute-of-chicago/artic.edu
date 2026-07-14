@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----magazine')
        @slot('images', $item->imagesFront('hero') ?? null)
        @slot('imagesMobile', $item->imagesFront('hero', 'mobile') ?? null)
        @slot('title', $item->present()->title ?? null)
        @slot('credit', $item->hero_caption ?? null)
        @slot('intro', $item->present()->hero_text ?? null)
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--magazine-issue">
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
                    @slot('authorDisplay', $item->welcome_note_author_override ?? $welcomeNote->showAuthors())
                    @slot('gtmAttributes', 'data-gtm-event="' . $welcomeNote->title . '" data-gtm-event-category="mag-note"')
                @endcomponent
            </div>
        @endif

        @php
            $fullWidthBlocks = ['custom_banner'];

            $sections = $item->blocks
                ->where('editor_name', 'default')
                ->where('parent_id', null)
                ->sortBy('position')
                ->chunkWhile(function ($block, $key, $chunk) use ($fullWidthBlocks) {
                    return !in_array($block->type, $fullWidthBlocks) && !in_array($chunk->last()->type, $fullWidthBlocks);
                });
        @endphp

        @foreach ($sections as $section)
            @if (in_array($section->first()->type, $fullWidthBlocks))
                @include('site.blocks.' . $section->first()->type, ['block' => $section->first()])
            @else
                @component('components.organisms._o-grid-listing')
                    @slot('variation', 'o-grid-listing--journal')
                    @slot('cols_xsmall','1')
                    @slot('cols_small','2')
                    @slot('cols_medium','2')
                    @slot('cols_large','2')
                    @slot('cols_xlarge','2')

                    @foreach ($section as $block)
                        @include('site.blocks.' . $block->type, ['block' => $block])
                    @endforeach
                @endcomponent
            @endif
        @endforeach
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
    <p class="f-secondary">The Art Institute is grateful to <a href="/thanks-to-our-supporters">our generous sponsors and partners</a> for supporting our mission to inspire an expansive understanding of human creativity through our collection of works of art across time, cultures, geographies, and identities.</p>
    </div>
</div>

@endsection
