@extends('layouts.app')

@section('content')

<article class="o-article">
    {{-- TODO: New header treatment --}}
    @if ($heroImage = $item->imageFront('hero') ?? null)
        @component('components.molecules._m-article-header----journal')
            @slot('title', $item->present()->title ?? null)
            @slot('img', $heroImage)
            @slot('credit', $item->hero_caption ?? null)
        @endcomponent
    @endif

    <div class="o-article__primary-actions">
        @component('components.molecules._m-article-actions----magazine-issue')
            @slot('issues', $issues)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->present()->editorsNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note')
                    @slot('title', $item->present()->editorsNote->present()->shortTitle)
                    @slot('description', $item->present()->editorsNote->present()->listDescription)
                    @slot('issueNumber', $item->issue_number ?? null)
                    @slot('articleLink', $item->present()->editorsNote->url)
                @endcomponent
            </div>
        @endif

        @if ($item->present()->articlesForLanding)
            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')
                @slot('cols_xsmall','1')
                @slot('cols_small','2')
                @slot('cols_medium','2')
                @slot('cols_large','2')
                @slot('cols_xlarge','2')
                @foreach ($item->present()->articlesForLanding as $item)
                    @component('components.molecules._m-listing----journal')
                        @slot('item', $item)
                        @slot('imageSettings', array(
                            'fit' => 'crop',
                            'ratio' => '16:9',
                            'srcset' => array(200,400,600),
                            'sizes' => aic_imageSizes(array(
                                  'xsmall' => '216px',
                                  'small' => '216px',
                                  'medium' => '18',
                                  'large' => '13',
                                  'xlarge' => '13',
                            )),
                        ))
                    @endcomponent
                @endforeach
            @endcomponent
        @endif

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
        <p class="f-secondary">Become a member or renew your membership today. Receive access to exhibition previews, exclusive events, and free admission year-round. Learn more.</p>
    </div>
</div>

@endsection
