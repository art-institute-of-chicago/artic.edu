@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----feature')
        @slot('variation', 'm-article-header--digital-publication')
        @slot('title', $item->present()->title)
        @slot('title_href', (request()->url() !== $item->present()->url) ? $item->present()->url : null)
        @slot('title_display', $item->present()->headerTitle())
        @slot('title_tag', (request()->url() !== $item->present()->url) ? 'a' : 'h1')
        @slot('subtitle_display', $item->present()->headerSubtitle())
        @slot('img', $item->imageFront('listing'))
        @slot('imgMobile', $item->imageFront('mobile_listing'))
        @slot('credit', $item->hero_caption ?? null)
        @slot('editorial', true)
        @slot('bgcolor', $item->bgcolor)
    @endcomponent

    @component('components.molecules._m-sidebar-toggle')
        @slot('title', 'Table of Contents')
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--digital-publication">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item)
            @slot('isLogoAnimated', true)
            @slot('citeAs', $item->cite_as)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->welcome_note_display && $showAll == false)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----publication')
                    @slot('description', $item->welcome_note_display)
                @endcomponent
            </div>
        @endif

        @foreach ($item->present()->topLevelArticles() as $topLevelArticle)

                @switch($topLevelArticle->listing_display)

                    @case('feature')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 4) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @if(count($topLevelArticle->children) > 0)
                                @foreach ($topLevelArticle->children->filter(function($item) {
                                    return !$item->suppress_listing;
                                    })->sortBy('position') as $item)
                                    @if ($loop->iteration <= 4)
                                        @if($loop->first)
                                            @component('components.molecules._m-showcase')
                                                @slot('variation', 'showcase--digital-publication')
                                                @slot('tag', $item->present()->label ?? null)
                                                @slot('title', $item->present()->title_display ?? $item->present()->title)
                                                @slot('author_display', $item->showAuthors())
                                                @slot('description', $item->present()->list_description)
                                                @slot('linkLabel', 'Read more')
                                                @slot('linkUrl', $item->present()->url)
                                                @slot('image', $item->imageFront('hero'))
                                                @slot('imageSettings', array(
                                                    'fit' => 'crop',
                                                    'ratio' => '16:9',
                                                    'srcset' => array(200,400,600),
                                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                                        'xsmall' => '216px',
                                                        'small' => '216px',
                                                        'medium' => '18',
                                                        'large' => '13',
                                                        'xlarge' => '13',
                                                    )),
                                                ))
                                            @endcomponent
                                        @else
                                            @if($loop->iteration == 2)
                                                @component('components.organisms._o-grid-listing')
                                                    @slot('cols_small','2')
                                                    @slot('cols_medium','3')
                                                    @slot('cols_large','3')
                                                    @slot('cols_xlarge','3')
                                            @endif
                                                @component('components.molecules._m-listing----digital-publication-article')
                                                    @slot('href', $item->present()->url)
                                                    @slot('image', $item->imageFront('hero'))
                                                    @slot('type', $item->present()->articleType)
                                                    @slot('title', $item->present()->title)
                                                    @slot('title_display', $item->present()->title_display)
                                                    @slot('list_description', $item->present()->list_description)
                                                    @slot('author_display', $item->showAuthors())
                                                    @slot('imageSettings', array(
                                                        'fit' => 'crop',
                                                        'ratio' => '16:9',
                                                        'srcset' => array(200,400,600),
                                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                                            'xsmall' => '216px',
                                                            'small' => '216px',
                                                            'medium' => '18',
                                                            'large' => '13',
                                                            'xlarge' => '13',
                                                        )),
                                                    ))
                                                @endcomponent
                                            @if($loop->last || ($loop->iteration == 4 && $showAll == false))
                                                @endcomponent
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                @component('components.molecules._m-showcase')
                                    @slot('variation', 'showcase--digital-publication')
                                    @slot('tag', $topLevelArticle->present()->articleType)
                                    @slot('title', $topLevelArticle->present()->title_display ?? $topLevelArticle->present()->title)
                                    @slot('author_display', $topLevelArticle->showAuthors())
                                    @slot('description', $topLevelArticle->present()->list_description)
                                    @slot('linkLabel', 'Read more')
                                    @slot('linkUrl', $topLevelArticle->present()->url)
                                    @slot('image', $topLevelArticle->imageFront('hero'))
                                    @slot('imageSettings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(200,400,600),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                            'xsmall' => '216px',
                                            'small' => '216px',
                                            'medium' => '18',
                                            'large' => '13',
                                            'xlarge' => '13',
                                        )),
                                    ))
                                @endcomponent
                            @endif
                        @endif
                    @break

                    @case('3-across')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @component('components.organisms._o-grid-listing')
                                @slot('cols_small','2')
                                @slot('cols_medium','3')
                                @slot('cols_large','3')
                                @slot('cols_xlarge','3')

                                @foreach ($topLevelArticle->children->filter(function($item) {
                                    return !$item->suppress_listing;
                                })->sortBy('position') as $item)
                                    @if ($loop->iteration <= 3 || $showAll == true)
                                    @component('components.molecules._m-listing----digital-publication-article')
                                        @slot('href', $item->present()->url)
                                        @slot('image', $item->imageFront('hero'))
                                        @slot('type', $item->present()->articleType)
                                        @slot('title', $item->present()->title)
                                        @slot('title_display', $item->present()->title_display)
                                        @slot('list_description', $item->present()->list_description)
                                        @slot('author_display', $item->showAuthors())
                                        @slot('imageSettings', array(
                                            'fit' => 'crop',
                                            'ratio' => '16:9',
                                            'srcset' => array(200,400,600),
                                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                                'xsmall' => '216px',
                                                'small' => '216px',
                                                'medium' => '18',
                                                'large' => '13',
                                                'xlarge' => '13',
                                            )),
                                        ))
                                    @endcomponent
                                    @endif
                                @endforeach
                            @endcomponent
                        @endif
                    @break

                    @case('entries')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                                @slot('links', (count($topLevelArticle->children) > 4 && count($topLevelArticle->children) != 8) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @component('components.organisms._o-grid-listing')
                                @slot('cols_xsmall','2')
                                @slot('cols_small','2')
                                @slot('cols_medium','4')
                                @slot('cols_large','4')
                                @slot('cols_xlarge','4')

                                @foreach ($topLevelArticle->children->filter(function($item) use($topLevelArticle) {
                                    return !$item->suppress_listing;
                                })->sortBy('position')->take($showAll ? $topLevelArticle->children->count() : (count($topLevelArticle->children) >= 8 ? 8 : 4)) as $item)
                                    @if (count($topLevelArticle->children) > 0)
                                        @component('components.molecules._m-listing----digital-publication-article-entry')
                                            @slot('href', $item->present()->url)
                                            @slot('image', $item->imageFront('hero', 'square') ?? $item->imageFront('hero'))
                                            @slot('title', $item->present()->title)
                                            @slot('title_display', $item->present()->title_display)
                                            @slot('label', $item->present()->label)
                                            @slot('imageSettings', array(
                                                'fit' => 'crop',
                                                'ratio' => $item->imageFront('hero', 'square') ? '1' : '16:9',
                                                'srcset' => array(200,400,600),
                                                'sizes' => ImageHelpers::aic_imageSizes(array(
                                                    'xsmall' => '216px',
                                                    'small' => '216px',
                                                    'medium' => '18',
                                                    'large' => '13',
                                                    'xlarge' => '13',
                                                )),
                                            ))
                                        @endcomponent
                                    @endif
                                @endforeach

                            @endcomponent
                        @endif
                    @break

                    @case('group_entries')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light  m-digipub-grouping-title-bar',
                            ])
                            @slot('links', $topLevelArticle->present()->getBrowseMoreLink($showAll))
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif
                        <br/>

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)

                            @if ($showAll == true)

                                    @foreach ($topLevelArticle->children->filter(function($item) {
                                        return !$item->suppress_listing;
                                    })->sortBy('position') as $item)

                                        @if ($item->children && $item->children->count() > 0)
                                            @component('components.molecules._m-title-bar', [
                                                'variation' => 'm-title-bar--no-hr m-digipub-subgrouping-title-bar',
                                                'titleFont' => 'f-list-2',
                                            ])
                                            {!! $item->title !!}
                                            @endcomponent

                                            @component('components.organisms._o-grid-listing')
                                                @slot('cols_xsmall','2')
                                                @slot('cols_small','2')
                                                @slot('cols_medium','4')
                                                @slot('cols_large','4')
                                                @slot('cols_xlarge','4')

                                                @foreach ($item->children as $child)
                                                    @component('components.molecules._m-listing----digital-publication-article-entry')
                                                        @slot('href', $child->present()->url)
                                                        @slot('image', $child->imageFront('hero'))
                                                        @slot('title', $child->present()->title)
                                                        @slot('title_display', $child->present()->title_display)
                                                        @slot('label', $child->present()->label)
                                                        @slot('imageSettings', array(
                                                            'fit' => 'crop',
                                                            'ratio' => '16:9',
                                                            'srcset' => array(200,400,600),
                                                            'sizes' => ImageHelpers::aic_imageSizes(array(
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
                                    @endforeach
                            @else
                                @component('components.organisms._o-grid-listing')
                                    @slot('cols_xsmall','1')
                                    @slot('cols_small','1')
                                    @slot('cols_medium','3')
                                    @slot('cols_large','3')
                                    @slot('cols_xlarge','3')

                                    @foreach ($topLevelArticle->children->filter(function($item) {
                                        return !$item->suppress_listing;
                                    })->sortBy('position') as $item)
                                        @if($loop->iteration <= 9 || $showAll == true)
                                            @component('components.molecules._m-listing----cover')
                                                @slot('variation', 'm-listing--cover--digital-publication')
                                                @slot('href', route(
                                                    'collection.publications.digital-publications.showListing',
                                                    [
                                                        'id' => $item->digitalPublication->id,
                                                        'slug' => $item->digitalPublication->getSlug()
                                                    ]
                                                ) . '#' . Str::kebab($item->title))
                                                @slot('image', $item->imageFront('hero'))
                                                @slot('title', $item->present()->title)
                                            @endcomponent
                                        @endif
                                    @endforeach


                                @endcomponent
                            @endif
                        @endif
                    @break

                    @case('list')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @component('components.organisms._o-grid-listing')
                                @slot('cols_small','1')

                                @foreach ($topLevelArticle->children->filter(function($item) {
                                    return !$item->suppress_listing;
                                })->sortBy('position') as $item)
                                    @if ($loop->iteration <= 3 || $showAll == true)
                                        @component('components.molecules._m-listing----digital-publication-article')
                                            @slot('variation', 'm-listing--seventy-thirty')
                                            @slot('href', $item->present()->url)
                                            @slot('image', $item->imageFront('hero'))
                                            @slot('type', $item->present()->articleType)
                                            @slot('title', $item->present()->title)
                                            @slot('title_display', $item->present()->title_display)
                                            @slot('list_description', $item->present()->list_description)
                                            @slot('author_display', $item->showAuthors())
                                            @slot('imageSettings', array(
                                                'fit' => 'crop',
                                                'ratio' => '16:9',
                                                'srcset' => array(200,400,600),
                                                'sizes' => ImageHelpers::aic_imageSizes(array(
                                                    'xsmall' => '216px',
                                                    'small' => '216px',
                                                    'medium' => '18',
                                                    'large' => '13',
                                                    'xlarge' => '13',
                                                )),
                                            ))
                                        @endcomponent
                                    @endif
                                @endforeach

                            @endcomponent
                        @endif
                    @break
                    @case('simple_list')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)

                            @if ($showAll == true)
                                @component('components.organisms._o-grid-listing')
                                    @slot('cols_small','2')
                                    @slot('cols_medium','3')
                                    @slot('cols_large','3')
                                    @slot('cols_xlarge','3')
                            @endif

                                @if(count($topLevelArticle->children) > 0)
                                    @foreach ($topLevelArticle->children->filter(function($item) {
                                        return !$item->suppress_listing;
                                    })->sortBy('position')->take($showAll ? count($topLevelArticle->children) : 3) as $item)
                                        @if ($showAll !== true)
                                            @component('components.molecules._m-digipub-title-bar', [
                                                'variation' => 'm-title-bar--compact m-title-bar--no-hr',
                                            ])
                                                @slot('item', $item)
                                                {!! $item->present()->articleType !!}
                                            @endcomponent
                                        @else
                                            @component('components.molecules._m-listing----digital-publication-article')
                                                @slot('variation', 'm-listing--title-only')
                                                @slot('href', $item->present()->url)
                                                @slot('image', $item->imageFront('hero'))
                                                @slot('type', $item->present()->articleType)
                                                @slot('title', $item->present()->title)
                                                @slot('title_display', $item->present()->title_display)
                                                @slot('list_description', $item->present()->list_description)
                                                @slot('author_display', $item->showAuthors())
                                                @slot('imageSettings', array(
                                                    'fit' => 'crop',
                                                    'ratio' => '16:9',
                                                    'srcset' => array(200,400,600),
                                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                                        'xsmall' => '216px',
                                                        'small' => '216px',
                                                        'medium' => '18',
                                                        'large' => '13',
                                                        'xlarge' => '13',
                                                    )),
                                                ))
                                            @endcomponent
                                        @endif
                                    @endforeach
                                @else
                                    @component('components.molecules._m-digipub-title-bar', [
                                        'variation' => 'm-title-bar--compact m-title-bar--no-hr',
                                    ])
                                        @slot('item', $topLevelArticle)
                                        {!! $topLevelArticle->present()->articleType !!}
                                    @endcomponent
                                @endif

                            @if ($showAll == true)
                                @endcomponent
                            @endif

                        @endif

                @break
                @default

                    {{-- Title Component --}}
                    @if (!$topLevelArticle->hide_title)
                        @component('components.molecules._m-title-bar', [
                            'variation' => 'm-title-bar--compact m-title-bar--light',
                        ])
                        @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                        {!! $topLevelArticle->title !!}
                        @endcomponent
                    @endif

                    {{-- Listing Component --}}
                    @if (!$topLevelArticle->suppress_listing)
                        @component('components.organisms._o-grid-listing')
                            @slot('cols_small','2')
                            @slot('cols_medium','3')
                            @slot('cols_large','3')
                            @slot('cols_xlarge','3')

                            @foreach ($topLevelArticle->children->filter(function($item) {
                                return !$item->suppress_listing;
                            })->sortBy('position') as $item)
                                @if ($loop->iteration <= 3 || $showAll == true)
                                @component('components.molecules._m-listing----digital-publication-article')
                                    @slot('href', $item->present()->url)
                                    @slot('image', $item->imageFront('hero'))
                                    @slot('type', $item->present()->articleType)
                                    @slot('title', $item->present()->title)
                                    @slot('title_display', $item->present()->title_display)
                                    @slot('list_description', $item->present()->list_description)
                                    @slot('author_display', $item->showAuthors())
                                    @slot('imageSettings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(200,400,600),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                            'xsmall' => '216px',
                                            'small' => '216px',
                                            'medium' => '18',
                                            'large' => '13',
                                            'xlarge' => '13',
                                        )),
                                    ))
                                @endcomponent
                                @endif
                            @endforeach
                        @endcomponent
                    @endif

                @endswitch
        @endforeach

        @if (isset($item->sponsor_display))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                Sponsors
            @endcomponent

            {!! $item->sponsor_display !!}
        @endif

        @if ($item->cite_as)
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                How to Cite
            @endcomponent

            {!! $item->cite_as !!}
        @endif
    </div>
</article>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
@endsection
